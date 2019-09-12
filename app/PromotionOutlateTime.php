<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOutlateTime extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_outlets_time';
    protected $primaryKey = 'pot_id';

    public function dayweek()
    {
        return $this->hasOne(DayOfWeek::class, 'dow_id', 'dow_id');
    }

    public function timeTag()
    {
        return $this->hasOne(TimeTags::class, 'tt_id', 'tt_id');
    }

}
