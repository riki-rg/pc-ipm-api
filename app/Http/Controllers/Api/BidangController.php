<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            // Ambil semua bidang, DAN serta-merta ambil data pengurus di dalamnya
            $bidang = Bidang::with('penguruses')->get();

            return $this->successResponse($bidang);

        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengambil data bidang', 500);
        }
    }
}