<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'status' => 1, 
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('!QAZxsw2'),
            'user_type' => 100
        ]);
    }
}
