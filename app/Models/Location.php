<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['street','dwelling','postal_code','city','country', 'lat', 'long'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
}
