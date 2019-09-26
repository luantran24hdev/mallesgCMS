<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TownMaster extends Model
{
    public $timestamps = false;
    protected $table = 'town_master';
    protected $primaryKey = 'town_id';


    public static function totalTownMall($cuid,$cid,$id){
        if(!empty($id)){
            $total = MallMaster::where('country_id',$cuid)->where('city_id',$cid)->where('town_id',$id)->where('mall_active','Y')->count();
            return $total;
        }
        return 0;
    }
}
