<?php

namespace App\Tools\NovaPermissionTool;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\Resource;
use Spatie\Permission\PermissionRegistrar;

class Role extends Resource {

  public static $model = \App\Models\Role::class;
  public static $title = 'name';
  public static $search = [
    'name',
  ];

  public static function getModel() {
    return app(\App\Models\Role::class);
  }

  public static function group() {
    return __('navigation.sidebar-label');
  }

  public static function availableForNavigation(Request $request) {
    /** @var User $user */
    $user = Auth::user();

    return $user->isRoot();

    //return Gate::allows('viewAny',
    //  app(PermissionRegistrar::class)->getRoleClass());
  }

  public static function label() {
    return __('resources.Roles');
  }

  public static function singularLabel() {
    return __('resources.Role');
  }

  public function fields(Request $request) {
    $guardOptions = collect(config('auth.guards'))->mapWithKeys(function ($value, $key) {
      return [$key => $key];
    });

    $userResource = Nova::resourceForModel(getModelForGuard($this->guard_name));

    return [
      ID::make(__('ID'), 'id')->sortable(),

      Text::make(__('roles.name'), 'name')
        ->rules(['required', 'string', 'max:255'])
        ->creationRules('unique:'.config('permission.table_names.roles'))
        ->updateRules('unique:'.config('permission.table_names.roles').',name,{{resourceId}}'),

      Select::make(__('roles.guard_name'), 'guard_name')
        ->options($guardOptions->toArray())
        ->rules(['required', Rule::in($guardOptions)]),

      DateTime::make(__('roles.created_at'), 'created_at')->exceptOnForms(),

      DateTime::make(__('roles.updated_at'), 'updated_at')->exceptOnForms(),

      PermissionBooleanGroup::make(__('roles.permissions'), 'permissions'),

      MorphToMany::make($userResource::label(), 'users', $userResource)
        ->searchable()
        ->singularLabel($userResource::singularLabel()),
    ];
  }
}
