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
Route::get('/capture', ['as'=>'user.capture.index','uses'=>'Backend\PresenceController@getCapture']);
Route::post('/capture', ['as'=>'user.capture.save','uses'=>'Backend\PresenceController@postCapture']);
Route::resource('/presence','Backend\PresenceController');
Route::get('/dopresence', ['as'=>'user.presence.index','uses'=>'Backend\PresenceController@getDoPresence']);


Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('/', ['as'=>'user.dashboard.index','uses'=>'Backend\DashboardController@dashboard']);


	// Route::get('/', function(){
	// 	if (Auth::user()->level == 'Admin'){
	// 		Route::get('/', ['as'=>'admin.dashboard.index','uses'=>'Backend\PresenceController@dashboard']);
	// 	}elseif (Auth::user()->level == 'Karyawan'){
	// 		return view('backend.dashboard.dashboard');
	// 	}elseif (Auth::user()->level == 'Manajer'){
	// 		return view('backend.dashboard.dashboard');
	// 	}
	// });
	
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

	//Presence Route
	Route::get('/presence/data', ['as'=>'admin.presence.index', 'uses'=>'Backend\PresenceController@getPresence']);
	Route::resource('/presence','Backend\PresenceController');
	Route::get('/data-presence', ['as'=>'admin.presence.data','uses'=>'Backend\PresenceController@dataPresences']);
	Route::get('/historypresence', ['as'=>'admin.historypresence.data','uses'=>'Backend\PresenceController@getList']);
	Route::get('/presence/print/{id}', ['as' => 'admin.printpresence.save', 'uses' => 'Backend\PresenceController@printHistoryPresence']);
	Route::get('/searchpresence', ['as' => 'admin.presence.search', 'uses' => 'Backend\PresenceController@searchPresence']);

	//Salary Route
	Route::resource('/salary','Backend\SalaryController');
	Route::get('/data-salary', ['as'=>'admin.salary.data','uses'=>'Backend\SalaryController@dataSalaries']);
	Route::get('/historysalary', ['as'=>'admin.historysalary.data','uses'=>'Backend\SalaryController@getList']);
	Route::get('/salary/print/{id}', ['as' => 'admin.printsalary.save', 'uses' => 'Backend\SalaryController@printHistorySalary']);
	Route::get('/searchsalary', ['as' => 'admin.salary.search', 'uses' => 'Backend\SalaryController@searchSalary']);
	Route::get('/employeesalary/print/{id}', ['as' => 'admin.printemployeesalary.save', 'uses' => 'Backend\SalaryController@printEmployeeSalary']);

	Route::get('/data-employeesalary', ['as'=>'admin.employeesalary.data','uses'=>'Backend\SalaryController@dataEmployeeSalaries']);
	Route::get('/employeesalary', ['as'=>'admin.employeesalary.index','uses'=>'Backend\SalaryController@getEmployeeSalary']);

	//Schedule Route
	Route::resource('/schedule','Backend\ScheduleController');
	Route::get('/data-schedule', ['as'=>'admin.schedule.data','uses'=>'Backend\ScheduleController@dataSchedules']);
	Route::get('/historyschedule', ['as'=>'admin.historyschedule.index','uses'=>'Backend\ScheduleController@getList']);
	Route::get('/schedule/print/{id}', ['as' => 'admin.printsalary.save', 'uses' => 'Backend\ScheduleController@printHistorySchedule']);
	Route::get('/searchschedule', ['as' => 'admin.schedule.search', 'uses' => 'Backend\ScheduleController@searchSchedule']);

	//Topsis Route
	Route::resource('/topsis','Backend\TopsisController');
	Route::get('/result', ['as' => 'admin.topsisresult.save', 'uses' => 'Backend\TopsisController@create']);
	Route::get('/topsis/createtopsis', ['as' => 'admin.topsiscreate.index', 'uses' => 'Backend\TopsisController@getFormTopsis']);


});

Route::group(['prefix'=>'employee','middleware' => ['auth', 'employee']], function () {

	//Presence Route
	Route::get('/presence', ['as' => 'employee.presence.index', 'uses' => 'Backend\PresenceController@getPresencesEmployee']);
	Route::get('/data-presence-employee', ['as'=>'employee.presence.data','uses'=>'Backend\PresenceController@dataPresencesEmployee']);

	//Schedule Route
	Route::get('/schedule', ['as' => 'employee.schedule.index', 'uses' => 'Backend\ScheduleController@getSchedulesEmployee']);
	Route::get('/data-schedule-employee', ['as'=>'employee.schedule.data','uses'=>'Backend\ScheduleController@dataSchedulesEmployee']);
});

Route::group(['prefix'=>'manager','middleware' => ['auth', 'manager']], function () {

	//Employee Route
	Route::get('/employee', ['as' => 'manager.employee.index', 'uses' => 'Backend\EmployeeController@getEmployees']);
	Route::get('/detailemployee/{id}', ['as' => 'manager.employee.detail', 'uses' => 'Backend\EmployeeController@getDetailEmployee']);
	Route::get('/data-employee-manager', ['as'=>'manager.employee.data','uses'=>'Backend\EmployeeController@dataEmployeesManager']);

	//Presence Route
	Route::get('/presence/data', ['as'=>'manager.presence.index', 'uses'=>'Backend\PresenceController@getPresence']);
	Route::resource('/presence','Backend\PresenceController');
	Route::get('/data-presence', ['as'=>'manager.presence.data','uses'=>'Backend\PresenceController@dataPresences']);
	Route::get('/historypresence', ['as'=>'manager.historypresence.data','uses'=>'Backend\PresenceController@getList']);
	Route::get('/presence/print/{id}', ['as' => 'manager.printpresence.save', 'uses' => 'Backend\PresenceController@printHistoryPresence']);
	Route::get('/searchpresence', ['as' => 'manager.presence.search', 'uses' => 'Backend\PresenceController@searchPresence']);

	//Salary Route
	Route::resource('/salary','Backend\SalaryController');
	Route::get('/data-salary', ['as'=>'manager.salary.data','uses'=>'Backend\SalaryController@dataSalaries']);
	Route::get('/historysalary', ['as'=>'manager.historysalary.data','uses'=>'Backend\SalaryController@getList']);
	Route::get('/salary/print/{id}', ['as' => 'manager.printsalary.save', 'uses' => 'Backend\SalaryController@printHistorySalary']);
	Route::get('/searchsalary', ['as' => 'manager.salary.search', 'uses' => 'Backend\SalaryController@searchSalary']);

	Route::get('/data-employeesalary', ['as'=>'manager.employeesalary.data','uses'=>'Backend\SalaryController@dataEmployeeSalaries']);
	Route::get('/employeesalary', ['as'=>'manager.employeesalary.index','uses'=>'Backend\SalaryController@getEmployeeSalary']);
	Route::get('/employeesalary/print/{id}', ['as' => 'manager.printemployeesalary.save', 'uses' => 'Backend\SalaryController@printEmployeeSalary']);
});

