<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class LevelActivity extends Model
{

    public $timestamps = false;
    protected $table = 'levels_activity';
    protected $primaryKey = 'la_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
	
}
