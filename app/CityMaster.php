<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityMaster extends Model
{
    //

    public $timestamps = false;
    protected $table = 'city_master';
    protected $primaryKey = 'city_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    public static function getCityName($id){
        if(!empty($id)){
            $city = CityMaster::find($id);

            return $city->city_name;
        }

        return '---';
    }
}
