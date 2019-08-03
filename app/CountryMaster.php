<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class CountryMaster extends Model
{

    public $timestamps = false;
    protected $table = 'country_master';
    protected $primaryKey = 'country_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
	
}
