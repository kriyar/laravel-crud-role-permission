<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    //Reset the users table
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('users')->truncate();

    // Generate admin user
    $date = Carbon::now();

    DB::table('users')->insert([
      [
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('secret'),
        'created_at' => $date,
        'updated_at' => $date,
      ]
    ]);
  }
}
