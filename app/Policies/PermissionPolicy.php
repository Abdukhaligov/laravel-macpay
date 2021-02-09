<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy {
  use HandlesAuthorization;

  public function viewAny(User $user) {
    return true;
  }

  public function view(User $user, Permission $permission) {
    return true;
  }

  public function create(User $user) {
    return true;
  }

  public function update(User $user, Permission $permission) {
    return true;
  }

  public function delete(User $user, Permission $permission) {
    return true;
  }

  public function restore(User $user, Permission $permission) {
    return true;
  }

  public function forceDelete(User $user, Permission $permission) {
    return true;
  }
}
