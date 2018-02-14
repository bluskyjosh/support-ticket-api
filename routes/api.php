<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//login and out routes route
Route::post('authenticate',['as'=>'authenticate','uses'=>'AuthController@login']);
Route::get('user_from_token',['as'=>'user_from_token', 'uses'=> 'AuthController@me']);
Route::post('logout', ['as'=> 'logout', 'uses' => 'AuthController@logout']);
Route::post('register', ['as' => 'register', 'uses' => 'AuthController@register']);


//Authenticated user Routes
Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('categories', 'CategoryController', ['except' => ['create', 'edit']]);
    Route::resource('my_tickets', 'UserTicketController', ['except' => ['create', 'edit']]);
    Route::resource('priorities', 'PriorityController', ['except' => ['create', 'edit']]);
    Route::resource('statuses', 'StatusController', ['except' => ['create', 'edit']]);
    Route::resource('tickets', 'TicketController', ['except' => ['create', 'edit']]);
    Route::resource('tickets/{ticket_id}/comments', 'TicketCommentController', ['except' => ['create', 'edit']]);
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
});
