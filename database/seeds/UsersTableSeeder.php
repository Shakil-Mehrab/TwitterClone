<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Shakil Mehrab',
            'username' => 'ShakilMehrab',
            'email' => 'mehrabhoussainshakil12@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
