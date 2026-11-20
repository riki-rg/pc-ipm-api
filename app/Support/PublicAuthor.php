<?php

namespace App\Support;

use App\Models\User;

class PublicAuthor
{
    public static function from(?User $user): ?array
    {
        $person = $user?->pengurus?->loadMissing('bidang');
        if (! $person) return null;

        return [
            'id' => $person->id,
            'name' => $person->nama_lengkap,
            'jabatan' => $person->jabatan,
            'foto_url' => $person->foto_url,
            'bidang' => $person->bidang?->nama,
            'email' => $person->email,
            'whatsapp' => $person->whatsapp,
            'kutipan' => $person->kutipan,
        ];
    }
}
