<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeTags extends Model
{
    public $timestamps = false;
    protected $table = 'time_tags';
    protected $primaryKey = 'tt_id';
}
