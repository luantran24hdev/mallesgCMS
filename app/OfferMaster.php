<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferMaster extends Model
{
    public $timestamps = false;
    protected $table = 'offer_master';
    protected $primaryKey = 'offer_id';

    public function mall(){
        return $this->hasOne(MallMaster::class,'mall_id','mall_id');
    }
}
