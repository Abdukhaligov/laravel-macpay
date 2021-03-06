<?php

namespace App\Tools\NovaPermissionTool;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPermissionTool extends Tool {
  public $roleResource = Role::class;
  public $permissionResource = Permission::class;

  public function boot() {
    Nova::resources([
      $this->roleResource,
      $this->permissionResource,
    ]);
  }

  public function roleResource(string $roleResource) {
    $this->roleResource = $roleResource;

    return $this;
  }

  public function permissionResource(string $permissionResource) {
    $this->permissionResource = $permissionResource;

    return $this;
  }
}
