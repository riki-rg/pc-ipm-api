<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlbumGaleri;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AlbumGaleriController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Ambil Album, urutkan terbaru
        // withCount('fotoGaleri') -> Biar kita tau ada berapa foto di dalemnya
        $data = AlbumGaleri::withCount('fotoGaleri')->latest()->get();
        
        return $this->successResponse($data);
    }

    public function show($id)
    {
        // Ambil detail album + LIST FOTO DI DALEMNYA
        $data = AlbumGaleri::with('fotoGaleri')->find($id);

        if (!$data) {
            return $this->errorResponse('Album tidak ditemukan', 404);
        }

        return $this->successResponse($data);
    }
}