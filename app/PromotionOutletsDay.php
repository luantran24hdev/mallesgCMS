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
}
