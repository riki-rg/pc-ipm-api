<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Traits\ApiResponse;

class KegiatanController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Tampilkan list kegiatan terbaru
        $data = Kegiatan::latest()->get();
        return $this->successResponse($data);
    }

    public function show($slug)
    {
        // Ambil detail kegiatan + DATA PENGURUS (Panitia)
        $data = Kegiatan::with('penguruses')->where('slug', $slug)->first();

        if (!$data) {
            return $this->errorResponse('Data tidak ditemukan', 404);
        }

        return $this->successResponse($data);
    }
}