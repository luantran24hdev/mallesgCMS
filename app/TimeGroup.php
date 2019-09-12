<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeGroup extends Model
{
    public $timestamps = false;
    protected $table = 'time_groups';
    protected $primaryKey = 'tg_id';

    public function time_group(){

        return $this->hasOne(TimeMaster::class, 'time_id', 'time_id');

    }

    public function time_tag(){
        return $this->hasOne(TimeTags::class, 'tt_id', 'tt_id');
    }
}
