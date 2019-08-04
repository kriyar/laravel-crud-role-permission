<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // reset roles table
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      DB::table('roles')->truncate();

      $roles = [
        'Super Admin',
        'Administrator',
        'Authenticated'
      ];

      foreach ($roles as $role_name) {
        $role = Role::create(['name' => $role_name]);
      }

      // reset model_has_roles table
      DB::table('model_has_roles')->truncate();

      $user = User::find(1);
      if (isset($user->id)) {
        $user->assignRole(['Super Admin', 'Authenticated']);
      }
    }
}
