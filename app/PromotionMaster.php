<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\PromotionMasterResource;
use App\PromotionDay;
use DB;


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
        'redeemable',
        'promo_active'
    ];

    public function merchant(){
        return $this->hasOne('App\MerchantMaster', 'merchant_id', 'merchant_id');
    }

    public function creator(){
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }

    public function promotion_tags(){
        return $this->hasMany('App\PromotionTag', 'promo_id', 'promo_id');
    }

    public function promotion_days(){

        //create if not exist
        if(!PromotionDay::find($this->promo_id)){
            PromotionDay::firstOrCreate(['promo_id'=>$this->promo_id]);
        }

        return $this->hasOne('App\PromotionDay', 'promo_id', 'promo_id');
    }

    public function images(){
        return $this->hasMany('App\MerchantPromoImage', 'promo_id', 'promo_id');
    }


	
}
