<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class UserAndRoleAndPermissionSeeder extends Seeder{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(){
    /** @var Role $adminRole */
    Role::create(['name' => 'root']);
    $adminRole = Role::create(['name' => 'admin']);

    $dashboard = Permission::create(['name' => 'view dashboard']);
    $nova = Permission::create(['name' => 'view nova']);
    $telescope = Permission::create(['name' => 'view telescope']);

    $adminRole->givePermissionTo($dashboard, $nova, $telescope);

    /** @var User $rootUser */
    $rootUser = User::create([
      "first_name" => "Hikmat",
      "last_name" => "Abdukhaligov",
      "email" => "hikmat.pou@gmail.com",
      "password" => '$2y$10$ngEqkacl5afq1W.6H2nd4eLdhQmvHUagfqKhklSd7C4BoHUfMK.Gq'
    ]);

    /** @var User $adminUser */
    $adminUser = User::create([
      "first_name" => "Hikmat",
      "last_name" => "Abdukhaligov",
      "email" => "admin@site.com",
      "password" => bcrypt(123456)
    ]);

    if ($rootUser) $rootUser->assignRole('root');
    if ($adminUser) $adminUser->assignRole('admin');
  }
}