<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    
    protected $fillable = [
    	'sender_id', 'receiver_id', 'sender_email', 'receiver_email', 'title', 'body', 'status'
    ];

    protected $guarded = [

    ];

    // public function user(){
    // 	return $this->belongsTo('App\User', 'sender_id', 'id');
    // }

}
