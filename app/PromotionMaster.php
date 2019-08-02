<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class PromotionMaster extends Model
{

    public $timestamps = false;
    protected $table = 'promotions_master';
    protected $primaryKey = 'promo_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_id',
        'merchant_id',
        'promo_name',
        'description',
        'amount',
        'other_offer',
        'dated',
        'start_on',
        'ends_on',
        'no_end_date',
        'active',
        'dm_id',
        'user_id',
        'redeemable'
    ];
	
}
