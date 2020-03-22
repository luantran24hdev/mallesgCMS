<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionMeal extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_meals';
    protected $primaryKey = 'pmg_id';

    public function meal_group(){
        return $this->hasOne(Mealgroup::class, 'mg_id', 'mg_id');
    }
}
