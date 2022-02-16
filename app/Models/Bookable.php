<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Bookable extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function extraodinaryEquipments()
    {
        return $this->hasMany(ExtraodinaryEquipment::class);
    }

    public function favoriteEquipments()
    {
        return $this->hasMany(FavoriteEquipment::class);
    }

    public function securityEquipments()
    {
        return $this->hasMany(SecurityEquipment::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function strongPoints()
    {
        return $this->hasMany(StrongPoint::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'bookable_id');
    }
    
    //methods
    public function thumbnail()
    {
        $thumbnail = $this->photos()->where('thumbnail', 1);
        return $thumbnail;
    }

    public function averageRating()
    {
        return $this->hasMany(Review::class, 'bookable_id', 'id')
        ->selectRaw('bookable_id,AVG(reviews.rating) AS rating')
        ->groupBy('bookable_id');
    }

    /* public function userPhoto()
    {
        $photo = ProfileImage::where('user_id', $this->user_id)->get(['cropped']);
        return [
            'photo' => $photo
        ];
    } */

    public function availableFor($from, $to) :bool
    {
        return 0 == $this->bookings()->betweenDates($from, $to)->count();
    }

    public function priceFor($from, $to) : array
    {
        $days = (new Carbon($from))->diffInDays(new Carbon($to));
        $price = $days * $this->price;

        return [
            'night' => $this->price,
            'duree' => $days,
            'total' => $price,
        ];
    }
}
