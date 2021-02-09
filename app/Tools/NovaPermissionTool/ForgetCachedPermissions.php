<?php

declare(strict_types=1);

namespace App\Tools\NovaPermissionTool;

use Closure;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Spatie\Permission\PermissionRegistrar;

class ForgetCachedPermissions {
  public function handle($request, $next) {
    $response = $next($request);

    if (
      $request->is('nova-api/*/detach') ||
      $request->is('nova-api/*/*/attach*/*')
    ) {
      //$permissionKey = Nova::resourceForModel(app(PermissionRegistrar::class)->getPermissionClass())::uriKey();

      //if ($request->viaRelationship === $permissionKey) {
      //  app(PermissionRegistrar::class)->forgetCachedPermissions();
      //}
    }

    return $response;
  }
}
