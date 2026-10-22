<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::take(5)->get();
        $users = User::take(4)->get();

        if ($products->isEmpty() || $users->count() < 2) {
            return;
        }

        $sampleComments = [
            5 => [
                'Excellent product quality! Came securely packed with official warranty card. Group buying saved me a good amount of money.',
                '100% authentic item. Build quality is top-notch and delivery took only 2 days in Dhaka. Highly recommended!',
                'Very pleased with this purchase. Both the solo discount and group deal options are great.',
            ],
            4 => [
                'Very good product for the price. Works exactly as described in the specs. Packaging was neat.',
                'Good experience overall. Team formed quickly and item arrived in pristine condition.',
            ],
        ];

        foreach ($products as $product) {
            foreach ($users->take(3) as $user) {
                $rating = rand(4, 5);
                $comment = $sampleComments[$rating][array_rand($sampleComments[$rating])];

                Review::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'rating' => $rating,
                        'comment' => $comment,
                    ]
                );
            }

            $avg = $product->reviews()->avg('rating');
            if ($avg) {
                $product->update(['rating' => round($avg, 1)]);
            }
        }
    }
}
