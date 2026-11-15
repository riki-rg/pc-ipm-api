<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    use ApiResponse;

    // List Berita Terbaru
    public function index()
    {
        $artikel = Artikel::where('status', 'published') // Cuma yg published
                    ->latest()
                    ->get();

        return $this->successResponse($artikel);
    }

    // Baca 1 Berita (Detail)
    public function show($slug)
    {
        $artikel = Artikel::with('user')->where('slug', $slug)->first();

        if (!$artikel) {
            return $this->errorResponse('Artikel tidak ditemukan', 404);
        }

        return $this->successResponse($artikel);
    }
}
