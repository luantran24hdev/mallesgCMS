<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class PromotionTag extends Model
{

    public $timestamps = false;
    protected $table = 'promotions_tags';
    protected $primaryKey = 'pt_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pt_id',
        'promo_id',
        'tag_id',
        'merchant_id',
        'primary_tag',
        'dated',
        'user_id',
    ];

    public function master(){
        return $this->belongsTo('App\TagMaster', 'tag_id', 'tag_id');
    }
	
}
