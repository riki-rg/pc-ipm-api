<?php

namespace App\Policies;

use App\Models\ProgramKerja;
use App\Models\User;

class ProgramKerjaPolicy
{
    public function viewAny(User $user): bool { return $user->can('view_any_program_kerja'); }
    public function view(User $user, ProgramKerja $record): bool { return $user->can('view_program_kerja'); }
    public function create(User $user): bool { return $user->can('create_program_kerja'); }
    public function update(User $user, ProgramKerja $record): bool { return $user->can('update_program_kerja'); }
    public function delete(User $user, ProgramKerja $record): bool { return $user->can('delete_program_kerja'); }
    public function deleteAny(User $user): bool { return $user->can('delete_any_program_kerja'); }
}
