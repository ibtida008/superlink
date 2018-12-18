<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'role', 'accepted'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userInfo(){
        return $this->hasOne('App\UserInfo');
    }

    public function link(){
        return $this->hasMany('App\Link');
    }
}
