<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()
                ->count(30)
                ->create();

        $bookables = Bookable::factory()->count(150)->make()->each(function ($bookable)
        {
            $bookable->user()->associate(User::inRandomOrder()->first());
            $bookable->save();
        });
    }
}