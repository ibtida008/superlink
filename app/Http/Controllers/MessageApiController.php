<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MessageApiController extends Controller
{

    public function postMessage(Request $request){

    	$rules = [
    		'sender_id' => 'required',
    		'receiver_email' => 'required',
    		'title' => 'required',
    		'body' => 'required'
    	];

    	$messages = [
    		'sender_id.required' => 'Sender Id is required',
    		'receiver_email.required' => 'Receiver email is required',
    		'title.required' => 'Title is required'
    	];

    	$validator = Validator::make($request->all(), $rules, $messages);

    	if($validator->fails()){
            $data = [
                'status' => 400,
                'errors' => $validator->errors()
            ];

            return response()->json($data);
        }

        $receiver = User::where('email', $request->receiver_email)->first();
        $sender = User::where('id', $request->sender_id)->first();

        if($receiver){}else{
        	$data = [
                'status' => 404,
                'message' => 'Receiver not found'
            ];

            return response()->json($data);
        }

        $message = new Message;
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $receiver->id;
        $message->sender_email = $sender->email;
        $message->receiver_email = $receiver->email;
        $message->title = $request->title;
        $message->body = $request->body ? $request->body : '';
        $message->sender_status = 'sent';
        $message->receiver_status = 'unread';

        if($message->save()){
            $data = [
                'status' => 200,
                'message' => 'Message sent successfully'
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

    public function fetchSentMessages($user_id){
    	$messages = Message::where('sender_id', $user_id)
    		->where('sender_status', 'sent')
    		->orderBy('id','desc')->get();
    	
    	foreach ($messages as $message) {
    		$message->time = $message->created_at->diffForHumans();
    	}
    	return response()->json($messages);
    }

    public function fetchInboxMessages($user_id){
    	$messages = Message::where('receiver_id', $user_id)
    		->where('receiver_status', '!=', 'deleted')
    		->orderBy('id','desc')->get();
    	
    	foreach ($messages as $message) {
    		$message->time = $message->created_at->diffForHumans();
    	}
    	return response()->json($messages);
    }

    public function deleteSenderMessage($id){

    	$message = Message::find($id);
    	$message->sender_status = 'deleted';

    	if($message->save()){
    		$data = [
	    		'status' => 200,
	    		'message' => 'Message Deleted Successfully'
	    	];

	    	return response()->json($data);
    	}else{
    		$data = [
	    		'status' => 400,
	    		'message' => 'Something went wrong'
	    	];

	    	return response()->json($data);
    	}
    	
    }

    public function deleteReceiverMessage($id){

    	$message = Message::find($id);
    	$message->receiver_status = 'deleted';

    	if($message->save()){
    		$data = [
	    		'status' => 200,
	    		'message' => 'Message Deleted Successfully'
	    	];

	    	return response()->json($data);
    	}else{
    		$data = [
	    		'status' => 400,
	    		'message' => 'Something went wrong'
	    	];

	    	return response()->json($data);
    	}
    	
    }

    
}
