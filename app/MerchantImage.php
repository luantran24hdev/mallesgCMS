<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantImage extends Model
{
    public $timestamps = false;
    protected $table = 'merchant_image';
    protected $primaryKey = 'merchant_image_id';
}
