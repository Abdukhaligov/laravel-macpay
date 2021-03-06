<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 */
class PayLinkTemplate extends Model {
  use ModelTrait;

  public function server() {
    return $this->belongsTo(Server::class);
  }
}
