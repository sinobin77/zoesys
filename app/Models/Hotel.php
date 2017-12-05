<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'm_hotel';
    protected $primaryKey = 'hotel_id';
    public $timestamps = false;

    public function organization()
    {
        return $this->belongsTo('\App\Organization','org_id');
        //return $this->belongsTo('\App\Organization');
    }

    public function roomtypes()
    {
        return $this->hasMany('\App\Models\Roomtype','hotel_id');
        //return $this->belongsTo('\App\Organization');
    }
}
