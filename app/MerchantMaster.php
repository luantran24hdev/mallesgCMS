<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class MerchantMaster extends Model
{

    public $timestamps = false;
    protected $table = 'merchant_master';
    protected $primaryKey = 'merchant_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'merchant_name',
		'city_id',
		'country_id',
		'town_id',
		'merchant_address',
		'postal_code',
		'telephone',
		'website',
		'company_id',
		'mt_id',
		'featured',
        'beta',
		'merchant_active',
		'main_image',
		'facebook',
		'instagram',
		'twitter',
		'youtube',
		'opening_hour',
		'about_us'
    ];


    public function locations(){
        return $this->hasMany('App\MerchantLocation', 'merchant_id', 'merchant_id');
    }

    public function promotions(){
        return $this->hasMany('App\PromotionMaster', 'merchant_id', 'merchant_id');
    }

    public function country(){
        return $this->belongsTo('App\CountryMaster', 'country_id', 'country_id');
    }
    public function city(){
        return $this->belongsTo('App\CityMaster', 'city_id', 'city_id');
    }
    public function merchanttype(){
        return $this->belongsTo('App\MerchantType', 'mt_id', 'mt_id');
    }





    
}
