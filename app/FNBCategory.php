<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FNBCategory extends Model
{
    public $timestamps = false;
    protected $table = 'f_n_b_category';
    protected $primaryKey = 'fnb_id';

    public static function search($name)
    {
        return FNBCategory::where('fnb_name','LIKE', "%$name%")
            ->orderBy('fnb_name')
            ->pluck('fnb_name', 'fnb_id');
    }

    public function fnbtype(){
        return $this->hasOne(FNBType::class,'fnbt_id','fnb_type');
    }
}
