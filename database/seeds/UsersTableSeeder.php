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
            [
                'id'            => 1,
                'name'          => 'Eugeny',
                'email'         => 'torbeev.eugeny@gmail.com',
                'password'      => bcrypt('123')
            ],
            [
                'id'            => 2,
                'name'          => 'Max',
                'email'         => 'max@gmail.com',
                'password'      => bcrypt('123')
            ],
            [
                'id'            => 3,
                'name'          => 'Alexandra',
                'email'         => 'alexandra@gmail.com',
                'password'      => bcrypt('123')
            ]
        ]);
    }
}
