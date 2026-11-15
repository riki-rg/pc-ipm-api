<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Traits\ApiResponse;

class HeroSlideController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            // Ambil semua slide, urutin dari angka 1, 2, 3...
            $slides = Slide::orderBy('urutan', 'asc')->get();

            return $this->successResponse($slides);

        } catch (\Exception $e) {
            return $this->errorResponse('Gagal mengambil data slide', 500);
        }
    }
}