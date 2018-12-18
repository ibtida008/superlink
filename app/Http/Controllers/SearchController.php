<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserInfo;

class SearchController extends Controller
{
    public function search(){
        return view('search');
    }

    public function searchUser($username){
    	$user = User::where('username', $username)->first();
    	$userinfo = UserInfo::where('id', $user->id)->first();

    	if($userinfo){
    		return response()->json($userinfo);
    	}else{
    		$data = [
    			'status' => 404,
    			'message' => 'User not found'
    		];
    	}

    }
}
