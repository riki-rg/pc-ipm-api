<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Traits\ApiResponse;

class PublicProfileController extends Controller
{
    use ApiResponse;

    public function show(int $id)
    {
        $person = Pengurus::with('bidang')->find($id);
        if (! $person) return $this->errorResponse('Profil tidak ditemukan', 404);

        return $this->successResponse([
            'id' => $person->id,
            'name' => $person->nama_lengkap,
            'jabatan' => $person->jabatan,
            'foto_url' => $person->foto_url,
            'bidang' => $person->bidang?->nama,
            'email' => $person->email,
            'whatsapp' => $person->whatsapp,
            'kutipan' => $person->kutipan,
        ]);
    }
}
