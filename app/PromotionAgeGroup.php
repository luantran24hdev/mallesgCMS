<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionAgeGroup extends Model
{
    public $timestamps = false;
    protected $table = 'promotions_age_groups';
    protected $primaryKey = 'pag_id';

    public function age_group(){
        return $this->hasOne(ManageAge::class, 'ag_id', 'ag_id');
    }
}
