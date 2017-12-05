<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    protected $table = 'm_hotel';
    protected $primaryKey = 'hotel_id';

    public function organization()
    {
        return $this->belongsTo('\App\Organization','org_id');
        //return $this->belongsTo('\App\Organization');
    }
}
