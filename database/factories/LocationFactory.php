<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dwelling = ['Small terraced house', 'large terraced house', 'Semi-detached house', 'Bungalow', 'Converted flat', 'Core and cluster accommodation', 'Live/work unit', 'Apartment', 'Building'];

        return [
            "street" => $this->faker->streetAddress(),
            "dwelling" => Arr::random($dwelling),
            "postal_code" => $this->faker->postcode(),
            "city" => $this->faker->city(),
            "country" => $this->faker->country(),
            'lat' => $this->faker->randomFloat(5, -90, 90),
            'long' => $this->faker->randomFloat(5, -90, 90)
        ];
    }
}
