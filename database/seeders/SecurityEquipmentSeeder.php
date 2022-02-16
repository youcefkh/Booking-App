<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\SecurityEquipment;
use Illuminate\Database\Seeder;

class SecurityEquipmentSeeder extends Seeder
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
            $nbr = random_int(1,3);
            $equipments = SecurityEquipment::factory($nbr)->make();
            $bookable->securityEquipments()->saveMany($equipments);
        });
    }
}
