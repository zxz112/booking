<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookable;
use App\Models\Review;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function(Bookable $bookable) {
            $reviews = collect([]);
            for ($i = 0; $i < random_int(0, 20); $i++) {
                $review = Review::factory()->make();
                $reviews->push($review);
            }
            $bookable->reviews()->saveMany($reviews);
        });
    }
}
