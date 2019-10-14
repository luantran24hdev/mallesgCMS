<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferenceMaster extends Model
{
    public $timestamps = false;
    protected $table = 'preference_master';
    protected $primaryKey = 'preference_id';

    public static function search($name)
    {
        return PreferenceMaster::where('preference_name','LIKE', "%$name%")
            ->orderBy('preference_name')
            ->pluck('preference_name', 'preference_id');
    }
}
