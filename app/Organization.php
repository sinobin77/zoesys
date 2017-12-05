<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'm_organization';

    protected $primaryKey = 'org_id';

    public function hotel()
    {
        return $this->hasOne('\App\Hotel','org_id');
    }

    public function hotels()
    {
        return $this->hasMany('\App\Hotel','org_id');
    }

    public function swipers()
    {
        return $this->hasMany('\App\Swiper','org_id');
    }
}
