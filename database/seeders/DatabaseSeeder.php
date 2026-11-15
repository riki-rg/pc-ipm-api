<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Cek dulu biar gak duplikat (safety)
        if (!User::where('email', 'developer@admin.pc.ipm.com')->exists()) {
            $user = User::create([
                'name' => 'Developer',
                'email' => 'developer@admin.pc.ipm.com',
                // Catatan: cast 'hashed' di User sudah meng-hash otomatis,
                // jadi password di sini harus plain, BUKAN Hash::make()
                'password' => 'Kawurk789',
                'email_verified_at' => now(),
            ]);

            $user->assignRole('admin');
        }
    }
}
