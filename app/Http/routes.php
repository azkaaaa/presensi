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

Route::get('/home', 'HomeController@index');

Route::auth();

//START KODING
Route::group(['middleware' => 'web'], function () {
	
});

//Presence Route
Route::resource('/presence','Backend\PresenceController');
Route::get('/dopresence', ['as'=>'user.presence.index','uses'=>'Backend\PresenceController@getDoPresence']);


Route::get('/capture', ['as'=>'user.capture.index','uses'=>'Backend\PresenceController@getCapture']);
Route::post('/capture', ['as'=>'user.capture.save','uses'=>'Backend\PresenceController@postCapture']);


Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('/', function(){
		if (Auth::user()->level == 'Admin'){
			return view('backend.dashboard.dashboard');
		}elseif (Auth::user()->level == 'Karyawan'){
			return view('backend.dashboard.dashboard');
		}elseif (Auth::user()->level == 'Manajer'){
			return view('backend.dashboard.dashboard');
		}
	});
	
});

Route::group(['middleware' => ['auth']], function () {

	//Update Profile Route
	Route::put('user/change/{id}', ['as'=>'user.changeprofile.save', 'uses'=>'Backend\AdminController@postChangeProfile']);
	Route::put('user/changepassword', ['as'=>'user.changepassword.save', 'uses'=>'Backend\AdminController@postChangePassword']);
	Route::get('/user/profile', ['as'=>'user.profile.index', 'uses'=>'Backend\AdminController@getProfile']);

	Route::get('/user/profile/picture', ['as'=>'user.changepicture.index', 'uses'=>'Backend\AdminController@getChangePicture']);
	Route::put('user/changepicture', ['as'=>'user.changepicture.save', 'uses'=>'Backend\AdminController@postChangePicture']);
});

Route::group(['prefix'=>'admin','middleware' => ['auth', 'admin']], function () {
	// Route::get('/dashboard', ['as'=>'admin.dashboard.index', 'uses'=>'Backend\AdminController@getDashboard']);

	//Position Route
	Route::resource('/position','Backend\PositionController');
	Route::get('/data-position', ['as'=>'admin.position.data','uses'=>'Backend\PositionController@dataPositions']);

	//User Route
	Route::resource('/user','Backend\UserController');
	Route::get('/data-user', ['as'=>'admin.user.data','uses'=>'Backend\UserController@dataUsers']);

	//Employee Route
	Route::resource('/employee','Backend\EmployeeController');
	Route::get('/data-employee', ['as'=>'admin.employee.data','uses'=>'Backend\EmployeeController@dataEmployees']);

	//Allowance Route
	Route::resource('/allowance','Backend\AllowanceController');
	Route::get('/data-allowance', ['as'=>'admin.allowance.data','uses'=>'Backend\AllowanceController@dataAllowances']);

	//Employee Allowance Route
	Route::resource('/empallowance','Backend\EmployeeAllowanceController');
	Route::get('/data-empallowance', ['as'=>'admin.empallowance.data','uses'=>'Backend\EmployeeAllowanceController@dataEmpAllowance']);

	//Employee Route
	Route::get('/presence/data', ['as'=>'admin.presence.index', 'uses'=>'Backend\PresenceController@getPresence']);
	Route::resource('/presence','Backend\PresenceController');
	Route::get('/data-presence', ['as'=>'admin.presence.data','uses'=>'Backend\PresenceController@dataPresences']);
});


