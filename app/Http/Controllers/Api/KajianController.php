<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kajian;
use App\Traits\ApiResponse;

class KajianController extends Controller
{
    use ApiResponse;

    public function index()
    {
        // Ambil data terbaru
        $data = Kajian::latest()->get();
        return $this->successResponse($data);
    }

    public function show($slug)
    {
        $data = Kajian::where('slug', $slug)->first();
        
        if (!$data) {
            return $this->errorResponse('Data tidak ditemukan', 404);
        }

        return $this->successResponse($data);
    }
}