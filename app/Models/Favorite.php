<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'bookable_id'];
    protected $table = 'favorites';

    public function bookables()
    {
        return $this->belongsToMany(Bookable::class);
    }
}
