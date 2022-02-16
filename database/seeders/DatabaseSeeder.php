<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            //BookableSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
            ProfileImageSeeder::class,
            CoverImageSeeder::class,
            FavortiteSeeder::class,
            LocationSeeder::class,
            ExtraodinaryEquipmentSeeder::class,
            FavoriteEquipmentSeeder::class,
            SecurityEquipmentSeeder::class,
            PhotoSeeder::class,
        ]);
    }
}
