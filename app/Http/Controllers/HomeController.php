<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->accepted == 1){
            if(Auth::user()->role == 'Admin'){
                return redirect('home_admin');
            }else{
                return redirect('home_user');
            }
        }else{
            Auth::logout();
            return redirect('login');
        }
    }

    public function index_admin(){
        return view('home_admin');
    }

    public function index_user(){
        return view('home_user');
    }

    
}
