<?php

namespace App\Tools\NovaPermissionTool;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Role as RoleModel;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasPermissions;

class RoleBooleanGroup extends BooleanGroup {
  public function __construct($name, $attribute = null, callable $resolveCallback = null, $labelAttribute = null) {
    parent::__construct($name, $attribute, $resolveCallback ?? static function (Collection $permissions) {
        return $permissions->mapWithKeys(function (RoleModel $role) {
          return [$role->name => true];
        });
      }
    );

    /** @var RoleModel $roleClass */
    $roleClass = app(PermissionRegistrar::class)->getRoleClass();

    /** @var User $user */
    $user = Auth::user();
    $ifRoot = $user->isRoot();

    $options = $ifRoot ?
      $roleClass::all()
        ->pluck($labelAttribute ?? 'name', 'name')
        ->toArray() :
      $roleClass::whereNotIn('id', [1, 2])
        ->get()
        ->pluck($labelAttribute ?? 'name', 'name')
        ->toArray();

    $this->options($options);
  }

  protected function fillAttributeFromRequest(
    NovaRequest $request,
    $requestAttribute,
    $model,
    $attribute
  ) {
    if (!$request->exists($requestAttribute)) {
      return;
    }

    $model->roles()->detach();

    collect(json_decode($request[$requestAttribute], true))
      ->filter(static function (bool $value) {
        return $value;
      })
      ->keys()
      ->map(static function ($roleName) use ($model) {
        /** @var RoleModel $roleClass */
        $roleClass = app(PermissionRegistrar::class)->getRoleClass();
        $role = $roleClass::where('name', $roleName)->first();
        $model->assignRole($role);

        return $roleName;
      });
  }
}
