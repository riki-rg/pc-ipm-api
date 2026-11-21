<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;
use App\Traits\ApiResponse;
use App\Support\PublicAuthor;
use Illuminate\Http\Request;

class AlbumGaleriController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Ambil Album, urutkan terbaru
        // withCount('fotoGaleri') -> Biar kita tau ada berapa foto di dalemnya
        $data = AlbumGaleri::with(['user.pengurus.bidang'])->withCount('fotoGaleri')->latest()->get();
        
        return $this->successResponse($data->map(function ($item) {
            $item->setAttribute('author', PublicAuthor::from($item->user));
            $item->unsetRelation('user');
            return $item;
        }));
    }

    public function show($id)
    {
        // Ambil detail album + LIST FOTO DI DALEMNYA
        $data = AlbumGaleri::with(['user.pengurus.bidang', 'fotoGaleri.user.pengurus.bidang'])->find($id);

        if (!$data) {
            return $this->errorResponse('Album tidak ditemukan', 404);
        }

        $data->setAttribute('author', PublicAuthor::from($data->user));
        $data->unsetRelation('user');
        $data->setRelation('fotoGaleri', $data->fotoGaleri->map(function ($foto) {
            $foto->setAttribute('author', PublicAuthor::from($foto->user));
            $foto->unsetRelation('user');
            return $foto;
        }));

        return $this->successResponse($data);
    }
}