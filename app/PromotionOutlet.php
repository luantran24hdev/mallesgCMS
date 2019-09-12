<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOutlet extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_outlets';
    protected $primaryKey = 'po_id';

    protected $guarded = [];

    public function merchant()
    {
        return $this->hasOne(MerchantMaster::class, 'merchant_id', 'merchant_id');
    }

    public function merchantLocation()
    {
        return $this->hasOne(MerchantLocation::class, 'merchantlocation_id', 'merchantlocation_id');
    }

    public function mall()
    {
        return $this->hasOne(MallMaster::class, 'mall_id', 'mall_id');
    }

    public function promotion_days(){

        return $this->hasOne(PromotionOutletsDay::class, 'po_id', 'po_id');
    }

    public static function totalOutlate($id){
        if(!empty($id)){
            $total = PromotionOutlet::where('merchant_id',$id)->count();
            return $total;
        }
        return 0;

    }
}
