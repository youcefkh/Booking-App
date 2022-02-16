<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = ["id"]; //opposite of fillable
    /* protected $fillable = ['first_name', 'last_name', 'username', 'email', 'address', 'country', 'city', 'zip_code', 'payment', 'name_on_card', 'card_number', 'card_expiration', 'cvv']; */

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
