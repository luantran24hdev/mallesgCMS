<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{
    public $timestamps = false;
    protected $table = 'events_master';
    protected $primaryKey = 'event_id';
}
