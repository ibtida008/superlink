<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Website;
use Illuminate\Support\Facades\Validator;

class WebsiteApiController extends Controller
{
    public function fetchWebsites(){
    	$websites = Website::all();
    	return response()->json($websites);
    }

    public function uploadLogo(Request $request){

        $rules = [
            'website_logo' => 'required|image'
        ];

        $messages = [
            'website_logo.required' => 'Please Select a Photo to Upload',
            'website_logo.image' => 'The Selected File to Upload is not an Image.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }

        $directory = 'uploads/website_logo/';

        $file = $request->website_logo;
        $name = str_replace([" ", "."], "_", $file->getClientOriginalName()) . "_";
        $file_name = $name . time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $file_name);

        $website = new Website;
        $website->website_name = 'Empty';
        $website->website_url = 'Empty';
        $website->website_logo ? unlink(public_path('/').$website->website_logo) : null;

        $website->website_logo = $directory . $file_name;
        $website->save();

        $data = [
        	'id' => $website->id,
            'status' => 200,
            'message' => 'Image Uploaded Successfully.',
            'image_file' => $directory . $file_name
        ];

        return response()->json($data);
    }

    public function postWebsite(Request $request){

    	// return response()->json($request);
    	$rules = [
            'website_name' => 'required'
        ];

        $messages = [
            'website_name.required' => 'Website name is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
        	$website = Website::find($request->id);
        	$website->delete();

            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }


        $website = Website::find($request->id);


        $website->website_name = $request->website_name;
        $website->website_url = $request->website_url ? $request->website_url : '';

        // $website->save();
        if($website->update()){
        	$data = [
                'status' => 200,
                'message' => 'New website is saved succesfully'
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

    public function deleteWebsite($id){
        $website = Website::find($id);
        if($website->delete()){
            $data = [
                'status' => 200,
                'message' => "Website Deleted"
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
