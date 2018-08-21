<?php

use Illuminate\Database\Seeder;
use  Illuminate\Support\Facades\DB as DB;
use Faker\Factory as Faker;
use App\User;


class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@clientmanagement.pro',
            'password' => 'admin'
        ]);
    }
}
