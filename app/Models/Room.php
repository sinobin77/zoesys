<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'm_hotel_room';
    protected $primaryKey = 'room_id';
    public $timestamps = false;

    public function roomtype()
    {
        return $this->belongsTo('\App\Models\Roomtype','roomtype_id');
        //return $this->belongsTo('\App\Organization');
    }
}
