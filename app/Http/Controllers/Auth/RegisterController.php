<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserInfo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $create_user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => ucfirst($data['role']),
            'password' => bcrypt($data['password']),
            'accepted' => 0
        ]);

        $user = User::where('email', $data['email'])->first();

        $userinfo = new UserInfo;
        $userinfo->user_id = $user->id;
        $userinfo->first_name = null;
        $userinfo->last_name = null;
        $userinfo->bio = null;
        $userinfo->city = null;
        $userinfo->state = null;
        $userinfo->country = null;
        $userinfo->video_link = null;
        $userinfo->profile_picture = 'uploads/no-image.jpg';
        $userinfo->save();

        return $create_user;
    }
}
