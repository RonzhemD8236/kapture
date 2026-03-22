<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'item_id'     => 1,
                'customer_id' => 1,
                'order_id'    => 1,
                'rating'      => 5,
                'comment'     => 'Absolutely stunning camera. The build quality is exceptional and the image clarity is unmatched.',
                'created_at'  => Carbon::now()->subDays(10),
                'updated_at'  => Carbon::now()->subDays(10),
            ],
            [
                'item_id'     => 2,
                'customer_id' => 1,
                'order_id'    => 2,
                'rating'      => 4,
                'comment'     => 'Great lens, very sharp. A little pricey but worth every peso.',
                'created_at'  => Carbon::now()->subDays(8),
                'updated_at'  => Carbon::now()->subDays(8),
            ],
            [
                'item_id'     => 3,
                'customer_id' => 2,
                'order_id'    => 3,
                'rating'      => 3,
                'comment'     => 'Decent product but the packaging could be better. Works as described.',
                'created_at'  => Carbon::now()->subDays(6),
                'updated_at'  => Carbon::now()->subDays(6),
            ],
            [
                'item_id'     => 4,
                'customer_id' => 2,
                'order_id'    => 4,
                'rating'      => 5,
                'comment'     => 'Perfect condition. Exactly what I was looking for. Fast delivery too!',
                'created_at'  => Carbon::now()->subDays(4),
                'updated_at'  => Carbon::now()->subDays(4),
            ],
            [
                'item_id'     => 5,
                'customer_id' => 3,
                'order_id'    => 5,
                'rating'      => 2,
                'comment'     => 'Not quite what I expected based on the description. Still functional though.',
                'created_at'  => Carbon::now()->subDays(3),
                'updated_at'  => Carbon::now()->subDays(3),
            ],
            [
                'item_id'     => 1,
                'customer_id' => 3,
                'order_id'    => 6,
                'rating'      => 4,
                'comment'     => 'Very good camera for the price. Highly recommend for beginners.',
                'created_at'  => Carbon::now()->subDays(2),
                'updated_at'  => Carbon::now()->subDays(2),
            ],
        ];

        DB::table('reviews')->insert($reviews);
    }
}