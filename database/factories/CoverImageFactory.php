<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CoverImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "original" => 'cover-img.jpg',
            "cropped" => 'cover-img.jpg',
        ];
    }
}
