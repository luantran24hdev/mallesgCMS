<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class LevelMaster extends Model
{

    public $timestamps = false;
    protected $table = 'level_master';
    protected $primaryKey = 'level_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
	
}
