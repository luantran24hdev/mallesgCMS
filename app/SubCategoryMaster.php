<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoryMaster extends Model
{
    //

    public $timestamps = false;
    protected $table = 'sub_category_master';
    protected $primaryKey = 'sub_category_id';

    public function category(){
        return $this->hasOne(CategoryMaster::class,'Category_id','Category_id');
    }

    public static function search($name)
    {
        return SubCategoryMaster::where('Sub_Category_name','LIKE', "%$name%")
            ->orderBy('Sub_Category_name')
            ->pluck('Sub_Category_name', 'sub_category_id');
    }

}
