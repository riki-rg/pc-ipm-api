<?php

namespace App\Policies;

use App\Models\ArsipRapat;
use App\Models\User;

class ArsipRapatPolicy
{
    public function viewAny(User $user): bool { return $user->can('view_any_arsip_rapat'); }
    public function view(User $user, ArsipRapat $record): bool { return $user->can('view_arsip_rapat'); }
    public function create(User $user): bool { return $user->can('create_arsip_rapat'); }
    public function update(User $user, ArsipRapat $record): bool { return $user->can('update_arsip_rapat'); }
    public function delete(User $user, ArsipRapat $record): bool { return $user->can('delete_arsip_rapat'); }
    public function deleteAny(User $user): bool { return $user->can('delete_any_arsip_rapat'); }
}
