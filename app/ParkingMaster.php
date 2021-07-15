<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingMaster extends Model
{
    public $timestamps = false;
    protected $table = 'parking_master';
    protected $primaryKey = 'parking_id';
    protected $fillable = ['mall_id', 'views', 'lots_cars', 'lots_bike', 'lots_handicap', 'lots_ev', 'lots_family', 'car_park_info' ,'grace_period','operating_hours','24_hours' , 'free_parking', 'car_charges', 'bike_charges', 'dated', 'user_id'];


}
