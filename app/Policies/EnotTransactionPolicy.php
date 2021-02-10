<?php

namespace App\Policies;

use App\Models\EnotTransaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnotTransactionPolicy {
  use HandlesAuthorization;

  public function viewAny(User $user) {
    return true;
  }

  public function view(User $user, EnotTransaction $enotTransaction) {
    return true;
  }

  public function create(User $user) {
    //
  }

  public function update(User $user, EnotTransaction $enotTransaction) {
    //
  }

  public function delete(User $user, EnotTransaction $enotTransaction) {
    //
  }

  public function restore(User $user, EnotTransaction $enotTransaction) {
    //
  }

  public function forceDelete(User $user, EnotTransaction $enotTransaction) {
    //
  }
}
