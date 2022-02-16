<?php

namespace Database\Seeders;

use App\Models\ProfileImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user)
        {
            $image = ProfileImage::factory()->make();
            $user->profileImage()->save($image);
        });
    }
}
