<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LinkApiController extends Controller
{
    public function postLink(Request $request){


    	$rules = [
            'user_id' => 'required',
            'website_id' => 'required',
            'url' => 'required'
        ];

        $messages = [
            'user_id.required' => 'User ID is required. May be you are not Authenticated.',
            'website_id.required' => 'Website ID is required',
            'url.required' => 'Your link url is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }

        // $link_exists = Link::where('user_id', $request->user_id)
        // 					->where('website_id', $request->website_id)->first();

       	// if($link_exists){
       	// 	$data = [
        //         'status' => 400,
        //         'errors' => 'You already have this link.'
        //     ];

        //     return response()->json($data);
       	// }

        $link = new Link;

        $link->user_id = $request->user_id;
        $link->website_id = $request->website_id;
        $link->url = $request->url;
        $link->title = $request->title ? $request->title : '';
        $link->description = $request->description ? $request->description : '';
        $link->hits = 0;
        
        if($link->save()){
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

    public function fetchLinks($id){

    	//$links = Link::where('user_id', $id)->get();

    	$links = DB::table('websites')
            ->join('links', 'links.website_id', '=', 'websites.id')
            ->where('links.user_id', $id)
            ->get();


    	return response()->json($links);
    }

    public function deleteLink($id){

    	$link = Link::find($id);
    	if($link->delete()){
    		$data = [
                'status' => 200,
                'message' => 'Link Deleted Successfully'
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

    public function updateHits($id){
        $link = Link::find($id);
        $link->hits = $link->hits + 1;
        if($link->save()){
            $data = [
                'status' => 200,
                'message' => 'Hits Updated'
            ];

            return response()->json($data);
        }else{
            $data = [
                'status' => 400,
                'message' => 'Error occured'
            ];

            return response()->json($data);
        }


    }
}
