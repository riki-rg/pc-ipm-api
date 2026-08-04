<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PembayaranKasPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'pembayaran-kas.view',
            'pembayaran-kas.view_any',
            'pembayaran-kas.create',
            'pembayaran-kas.update',
            'pembayaran-kas.delete',
            'pembayaran-kas.delete_any',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate([
                'name' => $p,
                'guard_name' => 'web',
            ]);
        }
    }
}
