<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionOutlet extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_outlets';
    protected $primaryKey = 'po_id';

    public function merchant()
    {
        return $this->hasOne(MerchantMaster::class, 'merchant_id', 'merchant_id');
    }

    public function merchantLocation()
    {
        return $this->hasOne(MerchantLocation::class, 'merchantLocation_id', 'merchangelocation_id');
    }
}
