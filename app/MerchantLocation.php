<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class MerchantLocation extends Model
{

    public $timestamps = false;
    protected $primaryKey = 'merchantLocation_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    public function floor(){
        return $this->hasOne('App\LevelMaster', 'level_id', 'level_id');
    }

    public function mall(){
        return $this->hasOne('App\MallMaster', 'mall_id', 'mall_id');
    }
	
}
