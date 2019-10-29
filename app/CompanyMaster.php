<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMaster extends Model
{
    public $timestamps = false;
    protected $table = 'company_master';
    protected $primaryKey = 'company_id';
}
