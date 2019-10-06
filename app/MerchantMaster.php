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

    public function loc($mid){


        $mall_types = \DB::table('mall_type')
            ->leftjoin('mall_master', 'mall_master.mt_id', '=', 'mall_type.mt_id')
            ->leftjoin('merchant_locations', 'merchant_locations.mall_id', '=', 'mall_master.mall_id')
            ->select('mall_type.mt_id')
            ->groupBy('mall_type.mt_id')
            ->where('merchant_locations.merchant_id', '=', $mid)
            ->get();


//return $mall_types;
        $locations = [];
        foreach ($mall_types as $mall_type){
            $locs = \DB::table('mall_master')
                ->leftjoin('merchant_locations', 'merchant_locations.mall_id', '=', 'mall_master.mall_id')
                ->leftjoin('level_master', 'merchant_locations.level_id', '=', 'level_master.level_id')
                ->leftjoin('mall_type', 'mall_master.mt_id', '=', 'mall_type.mt_id')
                ->where('merchant_locations.merchant_id', '=', $mid)
                ->select('merchant_locations.*','mall_type.type_name','mall_master.mall_name','level_master.level')
                ->where('mall_master.mt_id', '=', $mall_type->mt_id)
                ->get();
            $locations[$mall_type->mt_id]=$locs;
        }

        return $locations;
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

    public function merchantImage(){
        return $this->hasMany(MerchantImage::class, 'merchant_id', 'merchant_id');
    }





    
}
