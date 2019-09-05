<?php

namespace App;

use App\Http\Resources\PromotionMasterResource;
use DB;

use Illuminate\Database\Eloquent\Model;

class MallMaster extends Model
{

    public $timestamps = false;
    protected $table = 'mall_master';
    protected $primaryKey = 'mall_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function merchantLocations()
    {
        return $this->hasMany(MerchantLocation::class, 'mall_id', 'mall_id');
    }
}
