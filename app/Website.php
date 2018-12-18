<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = "websites";
    
    protected $fillable = [
    	'website_name', 'website_logo', 'website_url'
    ];

    protected $guarded = [

    ];

    public function link(){
    	return $this->hasMany('App\Link');
    }
}
