<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = "links";
    
    protected $fillable = [
    	'title', 'description', 'url', 'hits'
    ];

    protected $guarded = [

    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function website(){
    	return $this->belongsTo('App\Website');
    }

}
