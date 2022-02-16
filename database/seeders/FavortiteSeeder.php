<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Bookable;
use Illuminate\Database\Seeder;

class FavortiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::all();
        $users->each(function (User $user)
        {
            for($i=0; $i< random_int(1,10); $i++){
                $user->favorites()->attach(
                    Bookable::all()->random()->id
                );
            }
        });
    }
}
