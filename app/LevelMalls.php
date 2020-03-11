<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelMalls extends Model
{
    public $timestamps = false;
    protected $table = 'levels_malls';
    protected $primaryKey = 'lm_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    public function mall(){
        return $this->hasOne(MallMaster::class, 'mall_id', 'mall_id');
    }

    public function level(){
        return $this->belongsTo(LevelMaster::class, 'level_id', 'level_id');
    }

    public function level_activity(){
        return $this->belongsTo(LevelActivity::class, 'la_id', 'la_id');
    }
}
