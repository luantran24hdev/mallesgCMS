<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    public $timestamps = false;
    protected $table = 'event_image';
    protected $primaryKey = 'event_image_id';
}
