<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserInfo;
use App\Link;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller
{
    public function showUser($username){
        $user = User::where('username', $username)->first();
        $userinfo = UserInfo::where('user_id', $user->id)->first();
        return view('userlinks', compact('userinfo'));
    }
    public function fetchUsers(){
        $links = DB::table('users')
            ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->where('accepted', 1)
            ->get();

        return response()->json($links);
    }

    public function fetchPendingUsers(){
        $links = DB::table('users')
            ->join('user_infos', 'users.id', '=', 'user_infos.user_id')
            ->where('accepted', 0)
            ->get();
            
        return response()->json($links);
    }

    public function fetchCurrentUser(){
        if(Auth::check()){
            return response(Auth::user());
        }
        else{
            $data = [
            	'status' => 403,
            	'errors' => 'Authentication Problem'
            ];

            return response()->json($data);
        }
    }

    public function fetchUserInfo($id){

    	$user = UserInfo::where('user_id', $id)->first();
    	
    	if($user){
            return response($user);
        }
        else{
            $data = [
            	'status' => 404,
            	'errors' => 'User not found'
            ];

            return response()->json($data);
        }
    }

    public function postUserInfo(Request $request){

        $rules = [
            'user_id' => 'required'
        ];

        $messages = [
            'required' => 'User Not Found'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }

        $user_info = UserInfo::where('user_id', $request->user_id)->first();

        $user_info->first_name = $request->first_name ? $request->first_name : null;
        $user_info->last_name = $request->last_name ? $request->last_name : null;
        $user_info->city = $request->city ? $request->city : null;
        $user_info->state = $request->state ? $request->state : null;
        $user_info->country = $request->country ? $request->country : null;
        $user_info->bio = $request->bio ? $request->bio : null;
        $user_info->video_link = $request->video_link ? $request->video_link : null;

        if($user_info->save()){
            $data = [
                'status' => 200,
                'message' => 'Personal Info Saved Successfully'
            ];

            return response()->json($data);
        }
        else{
            $data = [
                'status' => 400,
                'errors' => 'Something went wrong. Please try again.'
            ];

            return response()->json($data);
        }
    }

    public function user_photo_upload(Request $request){

        $rules = [
            'profile_picture' => 'required|image'
        ];

        $messages = [
            'profile_picture.required' => 'Please Select a Photo to Upload',
            'profile_picture.image' => 'The Selected File to Upload is not an Image.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }

        $directory = 'uploads/users/';

        $file = $request->profile_picture;
        $name = str_replace([" ", "."], "_", $file->getClientOriginalName()) . "_";
        $file_name = $name . time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $file_name);

        $user_info = UserInfo::where('user_id', Auth::user()->id)->first();

        $user_info->profile_picture ? unlink(public_path('/').$user_info->profile_picture) : null;

        $user_info->profile_picture = $directory . $file_name;
        $user_info->save();

        $data = [
            'status' => 200,
            'message' => 'Image Uploaded Successfully.',
            'image_file' => $directory . $file_name
        ];

        return response()->json($data);
    }

    public function acceptUser($id){
        $user = User::find($id);
        $user->accepted = 1;
        if($user->save()){
            $data = [
                'status' => 200,
                'message' => "User Accepted"
            ];

            return response()->json($data);
        }else{
            $data = [
                'status' => 400,
                'errors' => 'Something went wrong. Please try again.'
            ];

            return response()->json($data);
        }

    }

    public function unacceptUser($id){
        $user = User::find($id);
        $user->accepted = 0;
        if($user->save()){
            $data = [
                'status' => 200,
                'message' => "User Accepted"
            ];

            return response()->json($data);
        }else{
            $data = [
                'status' => 400,
                'errors' => 'Something went wrong. Please try again.'
            ];

            return response()->json($data);
        }

    }

    public function deleteUser($id){
        $user = User::find($id);
        if($user->delete()){
            $data = [
                'status' => 200,
                'message' => "User Deleted"
            ];

            return response()->json($data);
        }else{
            $data = [
                'status' => 400,
                'errors' => 'Something went wrong. Please try again.'
            ];

            return response()->json($data);
        }

    }
}
