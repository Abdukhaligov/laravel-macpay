<?php

namespace App\Nova;

use App\Tools\NovaPermissionTool\Permission;
use App\Tools\NovaPermissionTool\Role;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource {
  public static $model = \App\Models\User::class;
  public static $title = 'name';
  public static $search = [
    'id', 'name', 'email',
  ];

  public function fields(Request $request) {
    return [
      ID::make()->sortable(),

      Gravatar::make()->maxWidth(50),

      Text::make('First Name')
        ->sortable()
        ->rules('max:255'),

      Text::make('Last Name')
        ->sortable()
        ->rules('max:255'),

      Text::make('Email')
        ->sortable()
        ->rules('required', 'email', 'max:254')
        ->creationRules('unique:users,email')
        ->updateRules('unique:users,email,{{resourceId}}'),

      Password::make('Password')
        ->onlyOnForms()
        ->creationRules('required', 'string', 'min:8')
        ->updateRules('nullable', 'string', 'min:8'),

      MorphToMany::make('Roles', 'roles', Role::class),

      MorphToMany::make('Permissions', 'permissions', Permission::class),
    ];
  }
}
