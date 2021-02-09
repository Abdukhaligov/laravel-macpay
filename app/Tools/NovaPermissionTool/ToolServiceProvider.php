<?php

namespace App\Tools\NovaPermissionTool;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider {
  public function boot() {
    $this->app->booted(function () {
      $this->routes();
    });

    Nova::serving(function (ServingNova $event) {
      //
    });
  }

  protected function routes() {
    if ($this->app->routesAreCached()) {
      return;
    }
    //
  }

  public function register() {
    //
  }
}
