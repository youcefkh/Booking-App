<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'original',
        'cropped',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
