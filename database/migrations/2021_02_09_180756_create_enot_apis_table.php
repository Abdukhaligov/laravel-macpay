<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnotApisTable extends Migration {
  public function up() {
    Schema::create('enot_apis', function (Blueprint $table) {
      $table->id();
      $table->string('ip')->nullable();
      $table->boolean("type")->default(false);
      $table->boolean("success")->default(true);
      $table->json('form')->nullable();
      $table->json('request')->nullable();
      $table->json('response')->nullable();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists('enot_apis');
  }
}
