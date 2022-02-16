<?php

namespace Database\Seeders;

use App\Models\CoverImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class CoverImageSeeder extends Seeder
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
            $cover = CoverImage::factory()->make();
            $user->coverImage()->save($cover);
        });
    }
}
