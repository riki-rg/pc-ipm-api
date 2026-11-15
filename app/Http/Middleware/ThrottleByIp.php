<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rate limit sederhana berbasis IP untuk endpoint publik.
 * Mitigasi spam/brute force tanpa dependensi eksternal.
 */
class ThrottleByIp
{
    protected int $maxAttempts;
    protected int $decaySeconds;

    public function __construct(int $maxAttempts = 10, int $decaySeconds = 60)
    {
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function handle(Request $request, Closure $next, ?string $maxAttempts = null, ?string $decaySeconds = null): Response
    {
        $key = 'throttle:' . ($maxAttempts ?? $this->maxAttempts) . ':' .
               ($decaySeconds ?? $this->decaySeconds) . ':' .
               ($request->ip() ?? 'unknown') . ':' . sha1($request->path());

        $attempts = cache()->get($key, 0);

        if ($attempts >= ($maxAttempts ?? $this->maxAttempts)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terlalu banyak permintaan. Coba lagi nanti.',
            ], 429);
        }

        cache()->put($key, $attempts + 1, now()->addSeconds($decaySeconds ?? $this->decaySeconds));

        return $next($request);
    }
}
