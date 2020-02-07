<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMaster extends Model
{
    public $timestamps = false;
    protected $table = 'category_master';
    protected $primaryKey = 'Category_id';

    public static function search($name)
    {
        return CategoryMaster::where('Category_name','LIKE', "%$name%")
            ->orderBy('Category_name')
            ->pluck('Category_name', 'Category_id');
    }
}
