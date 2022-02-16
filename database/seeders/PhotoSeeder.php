<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Bookable;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookables = Bookable::all()->each(function ($bookable)
        {
            $nbr = random_int(1,5);
            $photos = Collection::make(new Photo());
            for($i=1; $i<=5; $i++){
                $photo = Photo::make([
                    "name" => "fake".$i.".jpg",
                    "thumbnail" => $i==$nbr
                ]);

                $photos->push($photo);
            }

            $bookable->photos()->saveMany($photos);
        });
    }
}
