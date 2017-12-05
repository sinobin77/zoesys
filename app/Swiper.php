<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Swiper extends Model
{
    //
    protected $table = 'wx_swiper';
    protected $primaryKey = 'id';

    public function organization()
    {
        return $this->belongsTo('\App\Organization','org_id');
    }
}
