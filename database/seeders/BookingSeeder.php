<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable)
        {
            $booking = Booking::factory()->make();
            $bookings = collect([$booking]);

            for ($i=1; $i <= random_int(1,15); $i++) { 
                $user = User::inRandomOrder()->first();
                $from = (clone $booking->to)->addDays(random_int(1,14));
                $to = (clone $from)->addDays(random_int(1,14));

                $price = $bookable->priceFor($from, $to)['total'];

                $booking = Booking::make([
                    "from" => $from,
                    "to" => $to,
                    "price" => $price,
                ]);
                $booking->user_id = $user->id;
                $bookings->push($booking);
            }
            $id = User::inRandomOrder()->first()->id;
            $bookings[0]->user_id = $id; //cuz the first one didn't want to store the user id
            $bookable->bookings()->saveMany($bookings);
        });
    }
}
