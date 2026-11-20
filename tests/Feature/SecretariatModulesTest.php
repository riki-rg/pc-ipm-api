<?php

namespace Tests\Feature;

use App\Models\ArsipRapat;
use App\Models\ProgramKerja;
use App\Models\PeriodeKepengurusan;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SecretariatModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_secretariat_permissions_are_granted_only_to_sekum_and_admin(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $sekumRole = Role::findByName('sekum', 'web');
        $adminRole = Role::findByName('admin', 'web');
        $anggotaRole = Role::findByName('anggota', 'web');

        $sekum = User::factory()->create();
        $admin = User::factory()->create();
        $anggota = User::factory()->create();
        $sekum->assignRole($sekumRole);
        $admin->assignRole($adminRole);
        $anggota->assignRole($anggotaRole);

        $this->assertTrue(Gate::forUser($sekum)->allows('viewAny', ArsipRapat::class));
        $this->assertTrue(Gate::forUser($sekum)->allows('create', ArsipRapat::class));
        $this->assertTrue(Gate::forUser($sekum)->allows('viewAny', ProgramKerja::class));
        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', ProgramKerja::class));
        $this->assertFalse(Gate::forUser($anggota)->allows('viewAny', ArsipRapat::class));
        $this->assertFalse(Gate::forUser($anggota)->allows('viewAny', ProgramKerja::class));
    }

    public function test_program_kerja_dates_must_fit_inside_its_period(): void
    {
        $periode = PeriodeKepengurusan::create([
            'nama' => 'Uji Periode',
            'mulai' => '2026-01-01',
            'selesai' => '2026-12-31',
        ]);

        $program = new ProgramKerja([
            'periode_id' => $periode->id,
            'nama' => 'Proker validasi',
            'mulai' => '2025-12-30',
            'selesai' => '2026-02-01',
            'status' => 'Rencana',
        ]);

        $this->expectException(ValidationException::class);
        $program->save();
    }

    public function test_internal_archive_tables_are_separate_from_public_activities(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('arsip_rapat'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('program_kerja'));
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('periode_kepengurusan'));
        $this->assertFalse(\Illuminate\Support\Facades\Schema::hasColumn('kegiatans', 'ringkasan_keputusan'));
    }
}
