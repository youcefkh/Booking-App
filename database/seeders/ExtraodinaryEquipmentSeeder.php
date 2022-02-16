<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\ExtraodinaryEquipment;
use Illuminate\Database\Seeder;

class ExtraodinaryEquipmentSeeder extends Seeder
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
            $equipments = ExtraodinaryEquipment::factory($nbr)->make();
            $bookable->extraodinaryEquipments()->saveMany($equipments);
        });
    }
}
