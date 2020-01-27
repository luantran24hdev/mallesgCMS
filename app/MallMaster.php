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

    public function town(){
        return $this->belongsTo('App\TownMaster', 'town_id', 'town_id');
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

    public static  function locationByMallId($mall_id){

        $merchant_types = MerchantType::join('merchant_master','merchant_type.mt_id','=','merchant_master.mt_id')
            ->join('merchant_locations','merchant_master.merchant_id','=','merchant_locations.merchant_id')
            ->where('merchant_locations.mall_id',$mall_id)
            ->distinct('merchant_locations.mall_id')
            // ->groupBy('type')
            ->get();


        $locations = [];
        foreach ($merchant_types as $merchant_type){
            $merchant_locations = MerchantLocation::where('mall_id',$mall_id)
                ->join('merchant_master','merchant_master.merchant_id','=','merchant_locations.merchant_id')
                ->join('level_master', 'merchant_locations.level_id', '=', 'level_master.level_id')
                ->join('merchant_type','merchant_type.mt_id','=','merchant_master.mt_id')
                ->where('merchant_type.mt_id',$merchant_type->mt_id)
                ->distinct('mall_id')
                ->get(['level_master.*','merchant_type.*','merchant_master.merchant_name','merchant_locations.merchant_location']);


            $locations[$merchant_type->type]=$merchant_locations;
        }

        return $locations;
    }


    public function mallImage()
    {
        return $this->hasMany(MallImage::class, 'mall_id', 'mall_id')->where('image_count','!=',NULL);
    }

    public static function deleteMallData($id){

        $mall = MallMaster::find($id);
        $mall_images = MallImage::where('mall_id',$id)->get();
        if(!empty($mall_images)){
            foreach ($mall_images as $mallimage){
                $mallimage = MallImage::find($mallimage->mall_image_id);
                if(!empty($mallimage->image_name)){
                    unlink('../../admin/images/mall_images/' . $mallimage->image_name);
                }
                $mallimage->delete();
            }
        }

        if(!empty($mall->mall_logo)){

            unlink('../../admin/images/mall_logo/' . $mall->mall_logo);
            $malllogo = MallMaster::find($id);
            $malllogo->mall_logo = "";
            $malllogo->save();
        }
        if(!empty($mall->web_image)){
            unlink('../../admin/images/mall_images/' . $mall->web_image);
            $malllogo = MallMaster::find($id);
            $malllogo->web_image = "";
            $malllogo->save();
        }

        $parking_images = ParkingImages::where('mall_id',$id)->get();

        if(!empty($parking_images)){
            foreach ($parking_images as $parking_image){
                $parking_image = ParkingImages::find($parking_image->pi_id);
                if(!empty($parking_image->parking_image)){
                    unlink('../../admin/images/parking/'.$parking_image->parking_image);
                }
                $parking_image->delete();
            }
        }

        $events = EventMaster::where('mall_id',$id)->get();

        if(!empty($events)){
            foreach ($events as $event){
                $event = EventMaster::find($event->event_id);
                $eventImages = EventImages::where('event_id',$event->event_id)->get();
                if(!empty($eventImages)){
                    foreach ($eventImages as $eventimage){
                        $eventimage = EventImages::find($eventimage->event_image_id);
                        if(!empty($eventimage->event_image)){
                            unlink('../../admin/images/events/'.$eventimage->event_image);
                        }
                        $eventimage->delete();
                    }
                }
                $event->delete();
            }
        }

        $offers = OfferMaster::where('mall_id',$id)->get();

        if(!empty($offers)){
            foreach ($offers as $offer){
                $offer = OfferMaster::find($offer->offer_id);
                $offerImages = OfferImages::where('offer_id',$offer->offer_id)->get();
                if(!empty($offerImages)){
                    foreach ($offerImages as $offerImage){
                        $offerImage = OfferImages::find($offerImage->moi_id);
                        if(!empty($offerImage)){
                            unlink('../../admin/images/offers/'.$offerImage->Image_name);
                        }
                        $offerImage->delete();
                    }
                }
                $offer->delete();

            }
        }

        return true;

    }





}
