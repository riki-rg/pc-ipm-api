<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesanMasuk;
use App\Traits\ApiResponse;
use App\Http\Requests\StorePesanMasukRequest;

class PesanMasukController extends Controller
{
    use ApiResponse;

    public function store(StorePesanMasukRequest $request)
    {
        try {
            // Simpan ke database menggunakan validated data
            PesanMasuk::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'pesan' => $request->pesan,
                'is_read' => false, // Default belum dibaca
            ]);

            return $this->successResponse(null, 'Terima kasih, pesan Anda sudah kami terima!', 201);

        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengirim pesan, coba lagi nanti.', 500);
        }
    }
}