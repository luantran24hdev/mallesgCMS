<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingImages extends Model
{
    public $timestamps = false;
    protected $table = 'parking_images';
    protected $primaryKey = 'pi_id';


}
