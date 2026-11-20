<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $uri = ltrim($request->path(), '/');
        $isPasswordPage = $uri === 'admin/ganti-password';

        if ($user?->must_change_password && ! $isPasswordPage) {
            return redirect()->to('/admin/ganti-password');
        }

        return $next($request);
    }
}
