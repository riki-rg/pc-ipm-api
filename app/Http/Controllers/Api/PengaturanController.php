<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Ambil data pertama
        $pengaturan = Pengaturan::first();

        // 1. CEK DULU: Kalau kosong, jangan lanjut!
        if (!$pengaturan) {
            return response()->json([
                'status' => 'empty',
                'message' => 'Data Pengaturan belum diisi oleh Admin',
                'data' => null
            ], 200); // Tetap kasih 200 OK biar Frontend gak error
        }

        // 2. Kalau ada, baru balikin JSON
        return $this->successResponse($pengaturan);
    }
}