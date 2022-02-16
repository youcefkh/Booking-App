<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class FavoriteEquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $equipments = ['Wifi', 'TV', 'Kitchen', 'Washer', 'Free parking on premises', 'Paid parking on premises', 'Air conditioning', 'Dedicated workspace', 'Outdoor shower'];
        return [
            'name' => Arr::random($equipments)
        ];
    }
}
