<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Resource yang dikelola panel Filament (nama permission Shield:
     * view_any_{res}, view_{res}, create_{res}, update_{res}, delete_{res},
     * delete_any_{res}, force_delete_{res}, force_delete_any_{res},
     * restore_{res}, restore_any_{res}, replicate_{res}, reorder_{res})
     */
    private array $resources = [
        'role', 'permission', 'user',
        'pengurus', 'bidang',
        'artikel', 'kajian', 'kegiatan',
        'album_galeri', 'foto_galeri', 'slide',
        'pengaturan', 'pesan_masuk',
        'pembayaran_kas', 'pengeluaran',
    ];

    /** Bentuk akses: full = semua permission; view = view_any+view; */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Generate semua permission untuk semua resource (konvensi Shield)
        $actions = [
            'view_any', 'view', 'create', 'update', 'delete', 'delete_any',
            'force_delete', 'force_delete_any', 'restore', 'restore_any',
            'replicate', 'reorder',
        ];
        foreach ($this->resources as $res) {
            foreach ($actions as $act) {
                Permission::firstOrCreate(['name' => "{$act}_{$res}", 'guard_name' => 'web']);
            }
        }

        // 2. Helper permission set per resource
        $all = fn (string $r) => array_map(fn ($a) => "{$a}_{$r}", $actions);
        $viewOnly = fn (string $r) => ["view_any_{$r}", "view_{$r}"];
        $author = fn (string $r) => ["view_any_{$r}", "view_{$r}", "create_{$r}", "update_{$r}"];
        $cash = fn (string $r) => [...$viewOnly($r), "create_{$r}", "update_{$r}", "delete_{$r}", "delete_any_{$r}"];
        $moderator = fn (string $r) => [...$author($r), "delete_{$r}", "delete_any_{$r}", "replicate_{$r}"];
        $none = fn (string $r) => [];

        // 3. Definisi matrix role
        $matrix = [
            // admin / Developer: full akses ke semua
            'admin' => collect($this->resources)
                ->flatMap(fn ($r) => $all($r))
                ->all(),

            // Ketua Umum: supervisor — semua resource terlihat, kelola org & konten,
            // hapus konten; TIDAK mengelola role/permission/keuangan
            'ketum' => [
                ...$viewOnly('role'),
                ...$viewOnly('permission'),
                ...$moderator('user'),
                ...$moderator('pengurus'),
                ...$moderator('bidang'),
                ...$moderator('artikel'),
                ...$moderator('kajian'),
                ...$moderator('kegiatan'),
                ...$moderator('album_galeri'),
                ...$moderator('foto_galeri'),
                ...$moderator('slide'),
                ...$author('pengaturan'),
                ...$moderator('pesan_masuk'),
                ...$viewOnly('pembayaran_kas'),
            ],

            // Sekretaris Umum: kelola konten publik + arsip pesan; read-only org & kas
            'sekum' => [
                ...$viewOnly('pengurus'),
                ...$viewOnly('bidang'),
                ...$moderator('artikel'),
                ...$moderator('kajian'),
                ...$moderator('kegiatan'),
                ...$moderator('album_galeri'),
                ...$moderator('foto_galeri'),
                ...$moderator('pesan_masuk'),
                ...$viewOnly('slide'),
                ...$viewOnly('pembayaran_kas'),
            ],

            // Bendahara Umum: CRUD kas dan pengeluaran; anggota role lain view-only.
            'bendum' => [
                ...$cash('pembayaran_kas'),
                ...$cash('pengeluaran'),
                ...$viewOnly('pengurus'),
                ...$viewOnly('kegiatan'),
                ...$viewOnly('pesan_masuk'),
            ],

            // Ketua Bidang: kelola konten bidang (artikel/kajian/kegiatan/galeri),
            // input kas; read-only struktur org
            'kabid' => [
                ...$viewOnly('pengurus'),
                ...$viewOnly('bidang'),
                ...$moderator('artikel'),
                ...$moderator('kajian'),
                ...$moderator('kegiatan'),
                ...$moderator('album_galeri'),
                ...$moderator('foto_galeri'),
                ...$viewOnly('pembayaran_kas'),
                ...$viewOnly('pesan_masuk'),
            ],

            // Sekretaris Bidang: tulis/edit konten bidang, kelola galeri;
            // lihat kas
            'sekbid' => [
                ...$viewOnly('pengurus'),
                ...$viewOnly('bidang'),
                ...$author('artikel'),
                ...$author('kajian'),
                ...$author('kegiatan'),
                ...$moderator('album_galeri'),
                ...$moderator('foto_galeri'),
                ...$viewOnly('pembayaran_kas'),
                ...$viewOnly('pesan_masuk'),
            ],

            // Anggota Bidang: read-only konten publik
            'anggota' => [
                ...$viewOnly('artikel'),
                ...$viewOnly('kajian'),
                ...$viewOnly('kegiatan'),
                ...$viewOnly('album_galeri'),
                ...$viewOnly('foto_galeri'),
                ...$viewOnly('pengurus'),
            ],
        ];

        foreach (array_diff(array_keys($matrix), ['admin', 'bendum']) as $roleName) {
            $matrix[$roleName] = [...$matrix[$roleName], ...$viewOnly('pembayaran_kas'), ...$viewOnly('pengeluaran')];
        }

        // 4. Buat role + sync permissions
        foreach ($matrix as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        // Reset cache permission setelah seeding
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
