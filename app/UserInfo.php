<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = "user_infos";
    
    protected $fillable = [
    	'first_name', 'last_name', 'city', 'state', 'country', 'bio', 'video_link', 'profile_picture'
    ];

    protected $guarded = [

    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
