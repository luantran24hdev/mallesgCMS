<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingService extends Model
{
    public $timestamps = false;
    protected $table = 'parking_services';
    protected $primaryKey = 'ps_id';
    protected $fillable = ['service_id', 'parking_id',  'user_id', 'dated'];

}
