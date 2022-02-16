<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'content', 'rating', 'user_id', 'booking_id', 'bookable_id'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //overriding some function since we no lenger use auto incerement integer id

    public function bigIncrementing()
    {
        return 'false';
    }

    public function getKeyType()
    {
        return 'string';
    }
}
