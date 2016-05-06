<?php

use Illuminate\Database\Seeder;

class AdvertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adverts')->insert([
            [
                'id'            => 1,
                'title'         => 'This is a title of the advert #1 from user with ID = 1',
                'user_id'       => 1,
                'description'   => 'Some description of the advert #1',
                'price'         => 40000,
                'status'        => 'active'
            ],
            [
                'id'            => 2,
                'title'         => 'This is a title of the advert #2 from user with ID = 1',
                'user_id'       => 1,
                'description'   => 'Some description of the advert #2',
                'price'         => 12000,
                'status'        => 'active'
            ],
            [
                'id'            => 3,
                'title'         => 'This is a title of the advert #3 from user with ID = 2',
                'user_id'       => 2,
                'description'   => 'Some description of the advert #3',
                'price'         => 40000,
                'status'        => 'active'
            ],
            [
                'id'            => 4,
                'title'         => 'This is a title of the advert #4 from user with ID = 2',
                'user_id'       => 2,
                'description'   => 'Some description of the advert #4',
                'price'         => 40000,
                'status'        => 'active'
            ],
            [
                'id'            => 5,
                'title'         => 'This is a title of the advert #5 from user with ID = 3',
                'user_id'       => 3,
                'description'   => 'Some description of the advert #5',
                'price'         => 40000,
                'status'        => 'active'
            ]
        ]);
    }
}
