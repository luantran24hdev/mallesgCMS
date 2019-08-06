<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class MerchantPromoImage extends Model
{

    public $timestamps = false;
    protected $table = 'merchant_promo_image';
    protected $primaryKey = 'mallpromo_image_id';
	
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promo_id',
        'merchant_id',
        'image_name',
        'image_count',
        'date_added'
    ];
	
}
