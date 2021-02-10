<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnotTransaction extends Model {
  use ModelTrait;

  protected $fillable = ["steam_id", "amount", "server_id", "order_id"];

  public function server() {
    return $this->belongsTo(Server::class, 'server_id');
  }
}
