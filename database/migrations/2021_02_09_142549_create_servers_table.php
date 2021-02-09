<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration {
  public function up() {
    Schema::create('servers', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists('servers');
  }
}
