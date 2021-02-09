<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider {

  public function boot() {
    parent::boot();
  }

  protected function routes() {
    Nova::routes()
      ->withAuthenticationRoutes()
      ->withPasswordResetRoutes()
      ->register();
  }

  protected function gate() {
    Gate::define('viewNova', function ($user) {
      /** @var User $user */
      return $user->isRoot() || $user->hasPermissionTo('view nova');
    });
  }

  protected function cards() {
    return [
      new Help,
    ];
  }

  protected function dashboards() {
    return [];
  }

  public function tools() {
    return [
      \App\Tools\NovaPermissionTool\NovaPermissionTool::make(),
    ];
  }

  public function register() {
    //
  }
}
