<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MallType extends Model
{
    public $timestamps = false;
    protected $table = 'mall_type';
    protected $primaryKey = 'mt_id';

    public static function totalTypeMall($id){
        if(!empty($id)){
            $total = MallMaster::where('mt_id',$id)->where('mall_active','Y')->count();
            return $total;
        }
        return 0;
    }

}
