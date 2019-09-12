<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeMaster extends Model
{
    public $timestamps = false;
    protected $table = 'time_master';
    protected $primaryKey = 'time_id';
}
