<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantLocationImages extends Model
{
    public $timestamps = false;
    protected $table = 'merchant_locations_images';
    protected $primaryKey = 'mli_id';
}
