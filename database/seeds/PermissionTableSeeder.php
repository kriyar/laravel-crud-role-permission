<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
      DB::table('permissions')->truncate();

        $permissions = [
          ['name' => 'View permission list', 'group' => 'Permissions'],
          ['name' => 'Create permission', 'group' => 'Permissions'],
          ['name' => 'Edit permission', 'group' => 'Permissions'],
          ['name' => 'Delete permission', 'group' => 'Permissions'],
          ['name' => 'Administer permission', 'group' => 'Permissions'],
          ['name' => 'View role list', 'group' => 'Roles'],
          ['name' => 'Create role', 'group' => 'Roles'],
          ['name' => 'Edit role', 'group' => 'Roles'],
          ['name' => 'Delete role', 'group' => 'Roles'],
          ['name' => 'Administer role', 'group' => 'Roles'],
          ['name' => 'Administer user role', 'group' => 'Users'],
          ['name' => 'Administer role permission', 'group' => 'Users']
        ];

        foreach ($permissions as $permission) {
             Permission::create($permission);
        }
    }
}
