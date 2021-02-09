<?php

namespace App\Tools\NovaPermissionTool;

use App\Models\Role as RoleModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;

class AttachToRole extends Action {
  use InteractsWithQueue, Queueable, SerializesModels;

  public function handle(ActionFields $fields, Collection $models) {
    /** @var RoleModel $role */
    $role = Role::getModel()->find($fields['role']);
    foreach ($models as $model) {
      $role->givePermissionTo($model);
    }
  }

  public function fields() {
    /** @var User $user */
    $user = Auth::user();
    $ifRoot = $user->isRoot();

    $roles = Role::getModel();

    $roles = $ifRoot ?
      $roles
        ->all()
        ->pluck('name', 'id')
        ->toArray() :
      $roles
        ->whereNotIn('id', [1, 2])
        ->get()
        ->pluck('name', 'id')
        ->toArray();

    return [
      Select::make('Role')
        ->options($roles)
        ->displayUsingLabels(),
    ];
  }
}
