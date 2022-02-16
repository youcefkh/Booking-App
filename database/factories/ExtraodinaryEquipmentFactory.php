<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ExtraodinaryEquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $equipments = ['Pool', 'Hot tub', 'Patio', 'BBQ grill', 'Fire pit', 'Pool table', 'Indoor fireplace', 'Outdoor dining area','Exercice Equipment'];
        return [
            'name' => Arr::random($equipments)
        ];
    }
}
