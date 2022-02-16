<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecurityEquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $equipments = ['Smoke alarm', 'First aid kit', 'Carbon monoxide alarm', 'Fire extinguisher'];
        return [
            'name' => Arr::random($equipments)
        ];
    }
}
