<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider {
  public function register() {
    Telescope::night();

    $this->hideSensitiveRequestDetails();

    Telescope::filter(function (IncomingEntry $entry) {
      return true;

      if ($this->app->environment('local')) {
        return true;
      }

      return $entry->isReportableException() ||
        $entry->isFailedRequest() ||
        $entry->isFailedJob() ||
        $entry->isScheduledTask() ||
        $entry->hasMonitoredTag();
    });
  }

  protected function hideSensitiveRequestDetails() {
    return;

    if ($this->app->environment('local')) {
      return;
    }

    Telescope::hideRequestParameters(['_token']);

    Telescope::hideRequestHeaders([
      'cookie',
      'x-csrf-token',
      'x-xsrf-token',
    ]);
  }

  protected function gate() {
    Gate::define('viewTelescope', function ($user) {
      /** @var User $user */
      return $user->isRoot() || $user->hasPermissionTo('view telescope');
    });
  }
}
