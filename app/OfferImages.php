<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferImages extends Model
{
    public $timestamps = false;
    protected $table = 'mall_offers_images';
    protected $primaryKey = 'moi_id';
}
