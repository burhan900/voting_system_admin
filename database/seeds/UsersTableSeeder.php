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
        for ($i=0;$i< 1000;$i++){
            DB::table('users')->insert([
                'name' => str_random(15),
                'email' => str_random(15).'@gmail.com',
                'password' => bcrypt('secret'),
            ]);
        }

    }
}
