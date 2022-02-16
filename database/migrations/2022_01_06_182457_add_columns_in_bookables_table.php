<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInBookablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookables', function (Blueprint $table) {
            $table->string('bookable_type'); //appart,house,annex,guestroom,boutique hotel
            $table->string('property_type'); //appart: loft,.... / house: villa,... / ....
            $table->string('privacy_type'); //entire place, shared room, private room
            $table->string('hosting_type'); //private, professionnel
            $table->smallInteger('travelers');
            $table->smallInteger('beds');
            $table->smallInteger('rooms');
            $table->smallInteger('bathrooms');

            /* location: street, appartment/building.., postal code, city, country
            extraodinary_equipments;
            favorite_equipments;
            security_equipments;
            bookable_photos
            strong_points
            */


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookables', function (Blueprint $table) {
            //
        });
    }
}
