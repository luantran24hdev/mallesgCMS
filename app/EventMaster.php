<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMaster extends Model
{
    public $timestamps = false;
    protected $table = 'events_master';
    protected $primaryKey = 'event_id';

    const C = 'Current';
    const P = 'Past';
    const U = 'Upcoming';

    public function mall(){
        return $this->hasOne(MallMaster::class,'mall_id','mall_id');
    }
}
