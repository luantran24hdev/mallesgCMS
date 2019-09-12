<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferMaster extends Model
{
    public $timestamps = false;
    protected $table = 'offer_master';
    protected $primaryKey = 'offer_id';
}
