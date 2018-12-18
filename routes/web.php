<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@search');
Route::get('/search/user/{username}', 'SearchController@searchUser');

Route::get('/user/{username}', 'UserApiController@showUser');
Route::get('links/get/{id}', ['uses' => 'LinkApiController@fetchLinks']);
Route::get('link/update/hits/{id}', ['uses' => 'LinkApiController@updateHits']);

Route::group(['middleware' => ['auth']], function()
{
	Route::get('/home_admin', 'HomeController@index_admin');
	Route::get('/home_user', 'HomeController@index_user');

	//API Routes
	Route::get('current/user', ['uses' => 'UserApiController@fetchCurrentUser']);

	Route::get('user/info/get/{id}', ['uses' => 'UserApiController@fetchUserInfo']);
	Route::post('user/info/post', ['uses' => 'UserApiController@postUserInfo']);

	Route::post('user/photo/upload', ['as' => 'user/photo/upload', 'uses' => 'UserApiController@user_photo_upload']);

	Route::get('websites', ['uses' => 'WebsiteApiController@fetchWebsites']);

	
	Route::post('link/post', ['uses' => 'LinkApiController@postLink']);
	Route::get('link/delete/{link_id}', ['uses' => 'LinkApiController@deleteLink']);



	//Admin API Routes
	Route::get('users', ['uses' => 'UserApiController@fetchUsers']);
	Route::get('users/get/pending', ['uses' => 'UserApiController@fetchPendingUsers']);
	Route::get('user/accept/{id}', ['uses' => 'UserApiController@acceptUser']);
	Route::get('user/unaccept/{id}', ['uses' => 'UserApiController@unacceptUser']);
	Route::get('user/delete/{id}', ['uses' => 'UserApiController@deleteUser']);

	Route::get('websites', ['uses' => 'WebsiteApiController@fetchWebsites']);
	Route::get('website/delete/{id}', ['uses' => 'WebsiteApiController@deleteWebsite']);
	Route::post('website/logo/upload', ['uses' => 'WebsiteApiController@uploadLogo']);
	Route::post('website/post', ['uses' => 'WebsiteApiController@postWebsite']);

	Route::post('message/post', ['uses' => 'MessageApiController@postMessage']);
	Route::get('messages/inbox/{user_id}', ['uses' => 'MessageApiController@fetchInboxMessages']);
	Route::get('messages/sent/{user_id}', ['uses' => 'MessageApiController@fetchSentMessages']);
	Route::get('messages/sender/delete/{id}', ['uses' => 'MessageApiController@deleteSenderMessage']);
	Route::get('messages/receiver/delete/{id}', ['uses' => 'MessageApiController@deleteReceiverMessage']);

	

});
