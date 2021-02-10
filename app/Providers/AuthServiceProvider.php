<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Nova\EnotTransaction;
use App\Policies\EnotTransactionPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
  protected $policies = [
    User::class => UserPolicy::class,
    Role::class => RolePolicy::class,
    Permission::class => PermissionPolicy::class,
    EnotTransaction::class => EnotTransactionPolicy::class,
  ];

  public function boot() {
    $this->registerPolicies();
    //
  }
}
