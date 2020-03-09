<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyMaster extends Model
{
    public $timestamps = false;
    protected $table = 'company_master';
    protected $primaryKey = 'company_id';

    public static function search($name)
    {
        return CompanyMaster::where('company_name','LIKE', "%$name%")
            ->orderBy('company_name')
            ->pluck('company_name','company_id');
    }

}
