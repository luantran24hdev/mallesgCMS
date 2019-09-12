<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayOfWeek extends Model
{
    public $timestamps = false;
    protected $table = 'days_of_week';
    protected $primaryKey = 'dow_id';
}
