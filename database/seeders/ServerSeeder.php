<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder {
  public function run() {
    Server::create(["name" => "Tokio 1"]);
    Server::create(["name" => "Tokio 2"]);
    Server::create(["name" => "Los Angeles"]);
    Server::create(["name" => "Las Vegas"]);
    Server::create(["name" => "Moscow"]);
  }
}
