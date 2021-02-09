<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
  use HandlesAuthorization;

  public function viewAny(User $user) {
    return true;
  }

  public function view(User $user, User $model) {
    return !$model->isRoot();
  }

  public function create(User $user) {
    return true;
  }

  public function update(User $user, User $model) {
    return !$model->isRoot();
  }

  public function delete(User $user, User $model) {
    return !$model->isRoot();
  }

  public function restore(User $user, User $model) {
    return !$model->isRoot();
  }

  public function forceDelete(User $user, User $model) {
    return !$model->isRoot();
  }

  public function attachRole(User $user, User $model, Role $role) {
    if ($model->roles->contains($role->id)) return false;

    return (!$model->isRoot() && $role->id === 1) ? false : true;
  }

  public function detachRole(User $user, User $model, Role $role) {
    return ($model->id == 2 && $role->id === 2) ? false : true;
  }

  public function attachPermission(User $user, User $model, Permission $permission) {
    if ($model->permissions->contains($permission->id)) return false;

    return true;
  }
}
