<?php

namespace App\Tools\NovaPermissionTool;

use App\Models\Permission as PermissionModel;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Permission\PermissionRegistrar;

class PermissionBooleanGroup extends BooleanGroup {
  public function __construct($name, $attribute = null, callable $resolveCallback = null, $labelAttribute = null) {
    parent::__construct($name, $attribute, $resolveCallback ?? static function (Collection $permissions) {
        return $permissions->mapWithKeys(function (PermissionModel $permission) {
          return [$permission->name => true];
        });
      }
    );

    $permissionClass = app(PermissionRegistrar::class)->getPermissionClass();

    /** @var PermissionModel $permissionClass */
    $options = $permissionClass::all()
      ->pluck($labelAttribute ?? 'name', 'name')
      ->toArray();

    $this->options($options);
  }

  protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute) {
    if (!$request->exists($requestAttribute)) {
      return;
    }

    $values = collect(json_decode($request[$requestAttribute], true))
      ->filter(static function (bool $value) {
        return $value;
      })
      ->keys()
      ->toArray();

    $model->syncPermissions($values);
  }
}
