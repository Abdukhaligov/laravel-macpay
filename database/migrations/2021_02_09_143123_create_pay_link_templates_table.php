<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayLinkTemplatesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('pay_link_templates', function (Blueprint $table) {
      $table->id();
      $table->string("steam_id");
      $table->boolean("active")->default(true);
      $table->string("link")->nullable();
      $table->unsignedBigInteger("server_id");
      $table->foreign("server_id")->references("id")->on("servers")->onDelete("CASCADE");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('pay_link_templates');
  }
}
