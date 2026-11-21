<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;
use App\Models\Artikel;
use App\Models\Kajian;
use App\Models\Kegiatan;
use App\Models\Pengurus;
use App\Traits\ApiResponse;

class PublicProfileController extends Controller
{
    use ApiResponse;

    public function show(int $id)
    {
        $person = Pengurus::with('bidang')->find($id);
        if (! $person) return $this->errorResponse('Profil tidak ditemukan', 404);

        $userId = $person->user?->id;
        $uploads = collect();

        if ($userId) {
            $uploads = $uploads
                ->concat(Artikel::where('user_id', $userId)->where('status', 'published')->get()->map(fn ($item) => [
                    'type' => 'Artikel', 'title' => $item->judul, 'date' => $item->created_at?->toDateString(), 'image' => $item->gambar_header_url, 'url' => '/publikasi/berita/'.$item->slug,
                ]))
                ->concat(Kajian::where('user_id', $userId)->get()->map(fn ($item) => [
                    'type' => 'Kajian', 'title' => $item->judul, 'date' => $item->created_at?->toDateString(), 'image' => $item->gambar_header_url, 'url' => '/publikasi/kajian/'.$item->slug,
                ]))
                ->concat(Kegiatan::where('user_id', $userId)->get()->map(fn ($item) => [
                    'type' => 'Kegiatan', 'title' => $item->judul, 'date' => $item->created_at?->toDateString(), 'image' => $item->gambar_header_url, 'url' => '/publikasi/kegiatan/'.$item->slug,
                ]))
                ->concat(AlbumGaleri::where('user_id', $userId)->withCount('fotoGaleri')->get()->map(fn ($item) => [
                    'type' => 'Galeri', 'title' => $item->judul, 'date' => $item->created_at?->toDateString(), 'image' => $item->cover_url, 'url' => '/galeri/'.$item->id,
                ]))
                ->sortByDesc('date')->values();
        }

        return $this->successResponse([
            'id' => $person->id,
            'name' => $person->nama_lengkap,
            'jabatan' => $person->jabatan,
            'foto_url' => $person->foto_url,
            'bidang' => $person->bidang?->nama,
            'email' => $person->email,
            'whatsapp' => $person->whatsapp,
            'kutipan' => $person->kutipan,
            'uploads' => $uploads,
        ]);
    }
}
