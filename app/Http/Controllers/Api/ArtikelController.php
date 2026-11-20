<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Traits\ApiResponse;
use App\Support\PublicAuthor;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    use ApiResponse;

    // List Berita Terbaru
    public function index()
    {
        $artikel = Artikel::with('user.pengurus.bidang')->where('status', 'published') // Cuma yg published
                    ->orderByDesc('tanggal_publish')
                    ->orderByDesc('created_at')
                    ->get();

        $artikel->each(function ($item) {
            $item->setAttribute('author', PublicAuthor::from($item->user));
            $item->unsetRelation('user');
        });
        return $this->successResponse($artikel);
    }

    // Baca 1 Berita (Detail)
    public function show($slug)
    {
        $artikel = Artikel::with('user.pengurus.bidang')->where('slug', $slug)->first();

        if (!$artikel) {
            return $this->errorResponse('Artikel tidak ditemukan', 404);
        }

        $artikel->setAttribute('author', PublicAuthor::from($artikel->user));
        $artikel->unsetRelation('user');
        return $this->successResponse($artikel);
    }
}
