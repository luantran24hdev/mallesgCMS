<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class PromotionDay extends Model
{

    public $timestamps = false;
    protected $table = 'promo_days';
    protected $primaryKey = 'pd_id';
	
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
