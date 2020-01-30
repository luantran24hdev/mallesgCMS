<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MallOwner extends Model
{
    public $timestamps = false;
    protected $table = 'mall_owners';
    protected $primaryKey = 'mo_id';

    public static function search($name)
    {
        return MallOwner::where('mall_owner_name','LIKE', "%$name%")
            ->orderBy('mall_owner_name')
            ->pluck('mall_owner_name','mo_id');
    }
}
