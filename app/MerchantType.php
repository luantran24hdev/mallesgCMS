<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantType extends Model
{
    public $timestamps = false;
    protected $table = 'merchant_type';
    protected $primaryKey = 'mt_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    public static function totalTypeMerchant($id){
        if(!empty($id)){
            $total = MerchantMaster::where('mt_id',$id)->where('merchant_active','Y')->count();
            return $total;
        }
        return 0;
    }
}
