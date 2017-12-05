<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roomtype extends Model
{
    protected $table = 'room_type';
    protected $primaryKey = 'roomtype_id';
    public $timestamps = false;

    public function hotel()
    {
        return $this->belongsTo('\App\Models\Hotel','hotel_id');
        //return $this->belongsTo('\App\Organization');
    }

    public function rooms()
    {
        return $this->hasMany('\App\Models\Room','roomtype_id');
        //return $this->belongsTo('\App\Organization');
    }
}
