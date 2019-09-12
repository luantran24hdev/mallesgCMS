<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionPreference extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_preferences';
    protected $primaryKey = 'pp_id';


    public function preference(){
        return $this->hasOne(PreferenceMaster::class, 'preference_id', 'preference_id');
    }
}
