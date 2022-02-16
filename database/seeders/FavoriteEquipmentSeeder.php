<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\FavoriteEquipment;
use Illuminate\Database\Seeder;

class FavoriteEquipmentSeeder extends Seeder
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
            $nbr = random_int(1,5);
            $equipments = FavoriteEquipment::factory($nbr)->make();
            $bookable->favoriteEquipments()->saveMany($equipments);
        });
    }
}
