<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class RolePolicy {
  use HandlesAuthorization;

  public function viewAny(User $user) {
    return true;
  }

  public function view(User $user, Role $role) {
    $ifRoot = $role->name === "root";

    return !$ifRoot;
  }

  public function create(User $user) {
    return true;
  }

  public function update(User $user, Role $role) {
    $ifRoot = $role->name === "root" || $role->name === "admin";

    return !$ifRoot;
  }

  public function delete(User $user, Role $role) {
    $ifRoot = $role->name === "root" || $role->name === "admin";

    return !$ifRoot;
  }

  public function restore(User $user, Role $role) {
    return true;
  }

  public function forceDelete(User $user, Role $role) {
    return true;
  }

  public function detachUser(User $user, Role $role, User $model) {
    return ($model->id == 2 && $role->id == 2) ? false : true;
  }
}
