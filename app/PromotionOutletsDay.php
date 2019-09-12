<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOutletsDay extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_outlets_days';
    protected $primaryKey = 'pod_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_id',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ];

    public function outlatedata()
    {
        return $this->belongsTo(PromotionOutlet::class, 'po_id', 'po_id');
    }

    public function promomaster()
    {
        return $this->hasOne(PromotionMaster::class, 'promo_id', 'promo_id');
    }

    public function dayweek()
    {
        return $this->hasOne(DayOfWeek::class, 'dow_id', 'dow_id');
    }
}
