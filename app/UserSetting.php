<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    public $timestamps = false;
    protected $table = 'user_setting';
    protected $primaryKey = 'us_id';

    public function country(){
        return $this->belongsTo('App\CountryMaster', 'country_id', 'country_id');
    }
}
