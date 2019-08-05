<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class TagMaster extends Model
{

    public $timestamps = false;
    protected $table = 'tags_master';
    protected $primaryKey = 'tag_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];
	
}
