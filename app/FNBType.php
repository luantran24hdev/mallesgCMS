<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FNBType extends Model
{
    public $timestamps = false;
    protected $table = 'fnb_type';
    protected $primaryKey = 'fnbt_id';
}
