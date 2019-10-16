<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InquiryMaster extends Model
{
    public $timestamps = false;
    protected $table = 'Inquiry_master';
    protected $primaryKey = 'Inquiry_id';

    public function country(){
        return $this->hasOne(CountryMaster::class,'country_id','Country');
    }
}
