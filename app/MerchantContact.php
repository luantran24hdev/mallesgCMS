<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantContact extends Model
{
    public $timestamps = false;
    protected $table = 'merchant_contacts';
    protected $primaryKey = 'mrc_id';
}
