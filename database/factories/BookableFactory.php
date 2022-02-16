<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BookableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    
    public function definition()
    {
        $suffixes = [
           'Villa',
           'House',
           'Cottage',
           'Luxury Villas',
           'Cheap House',
           'Rooms',
           'Cheap Rooms',
           'Luxury Rooms',
           'Fancy Rooms'
        ];

        $bookable_types = ['Apartment', 'House', 'Secondary unit', 'Unique Space', 'Bed and breakfast', 'boutique hotel'];

        $property_types = [
            'Apartment'=>['Rental unit', 'Condominium', 'Loft', 'Serviced apartment', 'vacation home'],

            'House' => ['Residential home', 'Cabin', 'Villa', 'Townhouse', 'Cottage', 'Bungalow', 'Earth house', 'Houseboat', 'Farm Stay', 'Dome house', 'Chalet', 'Tiny house', 'Vacation home'],

            'Secondary unit' => ['Guest house', 'Guest suite', 'Farm stay', 'vacation home'],

            'Unique Space' => ['Barn', 'Boat', 'Bus', 'Camper', 'Treehouse', 'Campsite', 'Castle', 'Cave', 'Dome house', 'Earth house', 'Farm stay', 'Holiday park', 'Tent', 'Tipi', 'Tower', 'Train', 'Riad'],

            'Bed and breakfast' => ['Bed and breakfast', 'Nature lodge', 'Farm stay', 'Minsu', 'Casa particular', 'Ryokan'],

            'boutique hotel' => ['Hotel', 'Hostel', 'Resort', 'Nature lodge', 'Aparthotel', 'Serviced apartment', 'Heritage hotel', 'Kezhan']

        ];

        $privacy_types = ['Entire place', 'Shared room', 'Private room'];
        $hosting_types = ['Private', 'Professional'];

        $bookable_type = Arr::random($bookable_types);
        $property_type = Arr::random($property_types[$bookable_type]);


        return [
            'title' => $this->faker->city() .' '. Arr::random($suffixes),
            'content' => 'As soon as you walk into this Point Grey home you will be struck by the open space and clean lines – the perfect canvas on which to create your dream home. Situated across from unique Elk Lake, the floor plan has been beautifully adapted to modern life. Over 1,100 sq ft of living space which includes 2 beds and 2 bathrooms. Unique zoning for the building allows for legal short term rentals, pets allowed and a great onsite caretaker make this a worry free home. The extensive 2007 renovation has expanded floor space and functionality while respecting the integrity of the original design. It is ideally situated on a very private lot along a whisper quiet street. Beautiful log construction home on 1 acre. Smart Wiring Options, granite island, feature wall unit w/fireplace, field stone fireplace and drive in garage with workshop area lend a sophisticated feel to the home.',
            'price' => random_int(15, 600),
            'bookable_type' => $bookable_type,
            'property_type' => $property_type,
            'privacy_type' => Arr::random($privacy_types),
            'hosting_type' => Arr::random($hosting_types),
            'travelers' => random_int(1,15),
            'beds' => random_int(1,15),
            'rooms' => random_int(1,10),
            'bathrooms' => random_int(1,5),
        ];
    }
}
