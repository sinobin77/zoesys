<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corporation extends Model
{
    //
    protected $table = 'm_corporation';
    protected $primaryKey = 'corp_id';
    public $timestamps = false;
}
