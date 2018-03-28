<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('backend/layouts/master');
});

Route::get('admin/dashboard', function () {
    return view('backend/dashboard/dashboard');
});

Route::get('/home', 'HomeController@index');


//START KODING

Route::group(['middleware' => 'web'], function () {
	Route::auth();
});

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('/', function(){
		if (Auth::user()->level == 'admin'){
			return view('backend.dashboard.dashboard');
		}elseif (Auth::user()->level == 'employee'){
			return view('backend.dashboard.dashboard');
		}elseif (Auth::user()->level == 'manager'){
			return view('backend.dashboard.dashboard');
		}
	});
});

Route::group(['prefix'=>'admin','middleware' => ['auth', 'admin']], function () {
	Route::get('/dashboard', ['as'=>'admin.dashboard', 'uses'=>'AdminController@getDashboard']);

	//Position Route
	Route::resource('/position','Backend\PositionController');
	Route::get('/data-position', ['as'=>'admin.position.data','uses'=>'Backend\PositionController@dataPositions']);

	//User Route
	Route::resource('/user','Backend\UserController');
	Route::get('/data-user', ['as'=>'admin.user.data','uses'=>'Backend\UserController@dataUsers']);

	//Employee Route
	Route::resource('/employee','Backend\EmployeeController');
	Route::get('/data-employee', ['as'=>'admin.employee.data','uses'=>'Backend\EmployeeController@dataEmployees']);
});
