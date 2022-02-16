<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::all()->each(function (Booking $booking)
        {
            $review = Review::factory()->make();
            $review->bookable_id = $booking->bookable_id;
            $review->booking_id = $booking->id;
            $review->user_id = $booking->user_id;

            $review->save();

            /* $booking->review()->save($review);
            $user->user()->save($review);
            
            $bookable = Bookable::find($booking->id);
            $bookable->bookable()->save($review); */
        });
    }
}
