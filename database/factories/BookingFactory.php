<?php

namespace Database\Factories;

use App\Models\Bookable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $from = Carbon::instance($this->faker->dateTimeBetween('-1 months', '+1 months'));
        $to = (clone $from)->addDays(random_int(1, 14));
        $user = User::all()->random()->first();
        return [
            "from" => $from,
            "to" => $to,
            "price" => random_int(200, 5000),
            //"user_id" => $user->id
        ];
    }
}
