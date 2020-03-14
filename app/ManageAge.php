<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageAge extends Model
{
    public $timestamps = false;
    protected $table = 'age_group_master';
    protected $primaryKey = 'ag_id';
}
