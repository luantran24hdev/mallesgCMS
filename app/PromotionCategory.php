<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PromotionCategory extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_category';
    protected $primaryKey = 'pc_id';


    public static function subCatName($id){
        $data = SubCategoryMaster::find($id);

        //return $data->Sub_Category_name;
        if(!empty($data)){
            return $data->Sub_Category_name;
        }
        return "--";
    }

}
