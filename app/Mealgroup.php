<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mealgroup extends Model
{
    public $timestamps = false;
    protected $table = 'meal_group';
    protected $primaryKey = 'mg_id';
}
