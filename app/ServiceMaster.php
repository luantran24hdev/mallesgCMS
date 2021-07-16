<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    public $timestamps = false;
    protected $table = 'service_master';
    protected $primaryKey = 'service_id';
    protected $fillable = ['mall_id', 'service_name', 'service_image'];

    public static function search($name)
    {
        return ServiceMaster::where('service_name','LIKE', "%$name%")
            ->orderBy('service_name')
            ->pluck('service_name', 'service_id');
    }
}
