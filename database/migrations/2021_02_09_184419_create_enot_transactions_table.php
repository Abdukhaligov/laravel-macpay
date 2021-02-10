<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnotTransactionsTable extends Migration {
  public function up() {
    Schema::create('enot_transactions', function (Blueprint $table) {
      $table->id();
      $table->string('steam_id')->nullable();
      $table->string('amount')->nullable();
      $table->string('order_id')->nullable();
      $table->unsignedBigInteger('server_id')->nullable();
      $table->foreign('server_id')->references('id')->on('servers')->onDelete('SET NULL');
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists('enot_transactions');
  }
}
