<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryMaster extends Model
{
    public $timestamps = false;
    protected $table = 'category_master';
    protected $primaryKey = 'Category_id';
}
