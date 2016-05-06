<?php

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('offers')->insert([
            [
                'id'            => 1,
                'adv_id'        => 1,
                'user_id'       => 2,
                'title'         => 'Offer for the advert with ID = 1 from user with ID = 2',
                'description'   => 'Some description of the offer #1',
                'price'         => 42000,
                'status'        => 'active'
            ],
            [
                'id'            => 2,
                'adv_id'        => 2,
                'user_id'       => 3,
                'title'         => 'Offer for the advert with ID = 2 from user with ID = 3',
                'description'   => 'Some description of the offer #2',
                'price'         => 42000,
                'status'        => 'active'
            ],
            [
                'id'            => 3,
                'adv_id'        => 3,
                'user_id'       => 2,
                'title'         => 'Offer for the advert with ID = 3 from user with ID = 2',
                'description'   => 'Some description of the offer #3',
                'price'         => 42000,
                'status'        => 'active'
            ],
            [
                'id'            => 4,
                'adv_id'        => 4,
                'user_id'       => 1,
                'title'         => 'Offer for the advert with ID = 4 from user with ID = 1',
                'description'   => 'Some description of the offer #4',
                'price'         => 42000,
                'status'        => 'active'
            ],
            [
                'id'            => 5,
                'adv_id'        => 5,
                'user_id'       => 2,
                'title'         => 'Offer for the advert with ID = 5 from user with ID = 2',
                'description'   => 'Some description of the offer #5',
                'price'         => 42000,
                'status'        => 'active'
            ],
            [
                'id'            => 6,
                'adv_id'        => 5,
                'user_id'       => 1,
                'title'         => 'Offer for the advert with ID = 5 from user with ID = 1',
                'description'   => 'Some description of the offer #6',
                'price'         => 42000,
                'status'        => 'active'
            ]
        ]);
    }
}
