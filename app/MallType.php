<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MallType extends Model
{
    public $timestamps = false;
    protected $table = 'mall_type';
    protected $primaryKey = 'mt_id';

    public static function totalTypeMall($cuid,$cid,$id){
        if(!empty($id)){
            $total = MallMaster::where('country_id',$cuid)->where('city_id',$cid)->where('mt_id',$id)->where('mall_active','Y')->count();
            return $total;
        }
        return 0;
    }

    public static function getName($id){
        if(!empty($id)){
            $name =  MallType::where('mt_id',$id)->first('type_name');
            return $name->type_name;
        }
        return 0;
    }


}
