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
    public function malltype(){
        return $this->belongsTo('App\MallType', 'mt_id', 'mt_id');
    }


    public static function total_merchant($id){

        if(!empty($id)){
            $total_merchant = MerchantLocation::where('mall_id',$id)->distinct()->count();
            return $total_merchant;
        }
        return 0;
    }

    public static function total_event($id){
        if(!empty($id)){
            $total_event = EventMaster::where('mall_id',$id)->where('type','C')->count();
            return $total_event;
        }
        return 0;

    }

    public static function total_promos($id){
        if(!empty($id)){
            $total_promos = OfferMaster::where('mall_id',$id)->where('live','Y')->count();
            return $total_promos;
        }
        return 0;

    }






}
