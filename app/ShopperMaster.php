<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopperMaster extends Model
{

    public $timestamps = false;
    protected $table = 'shoppers_master';
    protected $primaryKey = 'Shopper_id';
}
