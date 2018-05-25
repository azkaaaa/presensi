<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
    	$dt = Carbon::now();
		$date = $dt->toDateString(); 
		$today = Carbon::today();

	    $salary = DB::table('salaries')
	        ->select('salaries.*')
	        ->whereMonth('salaries.created_at', '=', $dt->month)
	        ->first();

	    $schedule = DB::table('schedules')
	        ->select('schedules.*')
	        ->whereMonth('schedules.created_at', '=', $dt->month)
	        ->first();

	    $presences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('presences.*', DB::raw("DATE_FORMAT(presences.date, '%d %M %Y') new_date"), 'employees.name as employee_name', 'positions.name as position_name')
            ->orderBy('presences.date', 'desc')
	        ->where('presences.date', '=', $today)
	        ->get();

	    // dd($presences);

        return view('backend.dashboard.dashboard', ['salary'=>$salary, 'schedule'=>$schedule, 'presences'=>$presences, 'dt'=>$dt]);
    }

}
