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
        factory('App\Models\User', 1)->create([
            'mobile'     => '13970000000',
            'password' => bcrypt('abcdefg'),
        ]);
    }
}
