<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    public $timestamps = false;
    protected $table = 'events_category';
    protected $primaryKey = 'ec_id';
}
