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

    public static function search($name)
    {
        return TagMaster::where('tag_name','LIKE', "%$name%")
            ->orderBy('tag_name')
            ->pluck('tag_name', 'tag_id');
    }
	
}
