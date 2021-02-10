<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnotApi extends Model {
  use ModelTrait;

  const REQUEST = 0;
  const RESPONSE = 1;

  protected $fillable = ["form", "request", "response", "type", "success"];

  protected $casts = [
    "form" => "array",
    "request" => "array",
    "response" => "array",
    "type" => "boolean",
    "success" => "boolean"
  ];

  public function getTypeAttribute($value) {
    return $value ? "response" : "request";
  }
}
