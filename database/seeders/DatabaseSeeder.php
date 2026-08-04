<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <--- INI OBATNYA! (Jgn sampe lupa)
use Illuminate\Support\Facades\Hash; // Ini juga perlu buat Hash::make

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Cek dulu biar gak duplikat (safety)
        if (!User::where('email', 'developer@admin.pc.ipm.com')->exists()) {
            User::create([
                'name' => 'Developer',
                'email' => 'developer@admin.pc.ipm.com',
                'password' => Hash::make('Kawurk789'), // Password-nya: password
                // Kalo lo pake spatie roles, tambahin baris ini:
                'email_verified_at' => now(),
            ]);
            
            // JURUS ROLE (Kalo lo udh install Spatie Permission)
            // $user = User::where('email', 'developer@admin.pc.ipm.com')->first();
            // $user->assignRole('Super Admin');
        }
    }
}
