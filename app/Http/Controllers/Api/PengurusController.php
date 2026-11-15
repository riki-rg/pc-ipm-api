<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Traits\ApiResponse;

class PengurusController extends Controller
{
    use ApiResponse;

    public function pimpinan()
    {
        // Cari yang jabatannya mengandung kata "Ketua Umum" atau "Sekretaris Umum"
        // Kita pake 'LIKE' biar kalo lo nulis "Ketua Umum Periode 2025" tetep kena.
        $ketum = Pengurus::where('jabatan', 'LIKE', '%Ketua Umum%')->first();
        $sekum = Pengurus::where('jabatan', 'LIKE', '%Sekretaris Umum%')->first();

        return $this->successResponse([
            'ketum' => $ketum,
            'sekum' => $sekum,
        ]);
    }
}