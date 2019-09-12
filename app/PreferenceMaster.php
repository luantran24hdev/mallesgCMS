<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferenceMaster extends Model
{
    public $timestamps = false;
    protected $table = 'preference_master';
    protected $primaryKey = 'preference_id';
}
