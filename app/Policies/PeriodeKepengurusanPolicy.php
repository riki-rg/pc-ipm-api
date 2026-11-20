<?php

namespace App\Policies;

use App\Models\PeriodeKepengurusan;
use App\Models\User;

class PeriodeKepengurusanPolicy
{
    public function viewAny(User $user): bool { return $user->can('view_any_periode_kepengurusan'); }
    public function view(User $user, PeriodeKepengurusan $record): bool { return $user->can('view_periode_kepengurusan'); }
    public function create(User $user): bool { return $user->can('create_periode_kepengurusan'); }
    public function update(User $user, PeriodeKepengurusan $record): bool { return $user->can('update_periode_kepengurusan'); }
    public function delete(User $user, PeriodeKepengurusan $record): bool { return $user->can('delete_periode_kepengurusan'); }
    public function deleteAny(User $user): bool { return $user->can('delete_any_periode_kepengurusan'); }
}
