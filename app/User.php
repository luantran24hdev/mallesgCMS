<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_master';
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 
        'short_name', 
        'email_id', 
        'lara_password', 
        'user_type', 
        'created_on',
        'active',
        'confirmed',
        'status',
        'dash_access'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'lara_password',
    ];

    public function getAuthPassword()
    {
        return $this->lara_password;
    }
 
}
