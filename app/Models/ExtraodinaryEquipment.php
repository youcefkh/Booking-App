<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraodinaryEquipment extends Model
{
    use HasFactory;
    protected $table = 'extraodinary_equipments';
    protected $fillable = ['name'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }
}
