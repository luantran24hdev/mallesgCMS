<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class MallMaster extends Model
{

    public $timestamps = false;
    protected $table = 'mall_master';
    protected $primaryKey = 'mall_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function merchantLocations()
    {
        return $this->hasMany(MerchantLocation::class, 'mall_id', 'mall_id');
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
