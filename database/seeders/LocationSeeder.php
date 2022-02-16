<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookables = Bookable::all()->each(function ($bookable)
        {
            $location = Location::factory()->make();
            $location->bookable()->associate($bookable);
            $location->save();
        });
    }
}
