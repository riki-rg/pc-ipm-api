<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Traits\ApiResponse;
use App\Support\PublicAuthor;

class KegiatanController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Tampilkan list kegiatan terbaru
        $data = Kegiatan::with('user.pengurus.bidang')->latest()->get();
        return $this->successResponse($data->map(function ($item) {
            $item->setAttribute('author', PublicAuthor::from($item->user));
            $item->unsetRelation('user');
            return $item;
        }));
    }

    public function show($slug)
    {
        // Ambil detail kegiatan + DATA PENGURUS (Panitia)
        $data = Kegiatan::with(['user.pengurus.bidang', 'penguruses'])->where('slug', $slug)->first();

        if (!$data) {
            return $this->errorResponse('Data tidak ditemukan', 404);
        }

        $data->setAttribute('author', PublicAuthor::from($data->user));
        $data->unsetRelation('user');
        return $this->successResponse($data);
    }
}