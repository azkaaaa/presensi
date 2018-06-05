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
		if (Auth::user()->level == 'Admin' OR Auth::user()->level == 'Manajer'){

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

    	if (Auth::user()->level == 'Karyawan'){

    		$user = Auth::id();
    		$dt = Carbon::now();
			$today = Carbon::today();

    		$presences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('presences.*', DB::raw("DATE_FORMAT(presences.date, '%d %M %Y') new_date"), 'employees.name as employee_name', 'positions.name as position_name')
            ->orderBy('presences.date', 'desc')
	        ->where('presences.date', '=', $today)
	        ->where('presences.employee_id', '=', $user)
	        ->get();

	    	$kehadiran = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_kehadiran'))
            ->whereMonth('presences.date', '=', $dt->month)
            ->where('employee_id', '=', $user)
            ->first();

       		$terlambat = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_terlambat'))
            ->groupby('employee_id')
            ->whereMonth('presences.date', '=', $dt->month)
            ->where('presences.additional', '=', 'Terlambat')
            ->where('employee_id', '=', $user)
            ->first();

        	$lembur = DB::table('presences')
            ->select('presences.employee_id', DB::raw('count(presences.id) as total_lembur'))
            ->groupby('employee_id')
            ->whereMonth('presences.date', '=', $dt->month)
            ->where('presences.overtime_status', '=', 'Lembur')
            ->where('employee_id', '=', $user)
            ->first();

            if($kehadiran==NULL){
            	$kehadiran = 0;
     
            }
            if($terlambat==NULL){
            	$terlambat = 0;
     
            }
            if($lembur==NULL){
            	$lembur = 0;
            }

	    	return view('backend.dashboard.employee_dashboard', ['presences'=>$presences, 'dt'=>$dt, 'kehadiran'=>$kehadiran, 'terlambat'=>$terlambat, 'lembur'=>$lembur]);

    	}
    }

}
