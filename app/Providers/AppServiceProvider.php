<?php

namespace App\Providers;

use App\Models\PayLinkTemplate;
use App\Observers\PayLinkTemplateObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
  public function register() {
    //
  }

  public function boot() {
    PayLinkTemplate::observe(PayLinkTemplateObserver::class);
  }
}
