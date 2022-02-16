<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'price', 'user_id'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query->where('from', '<=', $to)->where('to', '>=', $from);
    }

    public static function findByReviewKey(string $reviewKey) //expect to retun a Booking object or null
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
        /* return DB::table('bookings')
            ->where('review_key', $reviewKey)
            ->join('bookables', 'bookables.id', '=', 'bookings.bookable_id')
            ->select('bookings.*', 'bookables.*')
            ->get()->first(); */
    }

    protected static function boot()
    {
        //always call the parent method
        parent::boot();

        //whenever an instance of Booking is created assign a review_key to it
        static::creating(function ($booking)
        {
            $booking->review_key = Str::uuid();
        });
    }
}
