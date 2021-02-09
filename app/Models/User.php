<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
  use ModelTrait, Notifiable, HasRoles;

  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function isRoot(): bool {
    try {
      return in_array(Role::where("name", "Root")->first()->id,
        (array) $this->roles->pluck('id')->toArray());
    } catch (\Exception $e) {
      return false;
    }
  }
}
