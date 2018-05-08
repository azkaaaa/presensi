<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Employee;
use App\Allowance;
use App\Salary;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use DB;
use PDF;
use Carbon\Carbon;

class SalaryController extends Controller
{

	public function index()
    {
    	$dt = Carbon::now();
	    $date = $dt->toDateString(); 

    	$salary = DB::table('salaries')
           ->select('salaries.*')
           ->whereMonth('salaries.created_at', '=', $dt->month)
           ->first();

        return view('backend.salary.index', ['salary'=>$salary, 'dt'=>$dt]);
    }

  public function getList()
    {
    	$salary = DB::table('salaries')
            ->join('employees', 'employees.id', '=', 'salaries.employee_id')
            ->select('employees.name as employee_name', 'salaries.*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->groupBy('salaries.list')
            ->orderBy('salaries.created_at', 'desc')
            ->get();
            // ->whereMonth('presences.date', '=', $dt->month);
        return view('backend.salary.history', ['salary'=>$salary]);
    }

	public function dataSalaries()
  	{
  		$dt = Carbon::now();
	    $date = $dt->toDateString(); 

    	 $salary = DB::table('employees')
            ->join('presences', 'presences.employee_id', '=', 'employees.id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.*', DB::raw('count(presences.employee_id) as total_presences'), DB::raw('count(presences.employee_id)*positions.salary as total_salary'), DB::raw('sum(positions.transport) as total_transport'), DB::raw('sum(presences.overtime)*20000 as total_overtime'), DB::raw('(count(presences.employee_id)*positions.salary) + sum(positions.transport) + (sum(presences.overtime)*20000) as total_all'))
            ->groupBy('employees.id')
            ->whereMonth('presences.date', '=', $dt->month);

        if (Auth::user()->level == 'Admin'){
          return Datatables::of($salary)
          ->addColumn('action', function ($salary) {
                return '<a href="'.url('admin/salary/'. $salary->id).'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Detail</a>';
              }
            )
          ->make(true);
        }

        elseif (Auth::user()->level == 'Manajer'){
          return Datatables::of($salary)
          ->addColumn('action', function ($salary) {
                return '<a href="'.url('manager/salary/'. $salary->id).'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Detail</a>';
              }
            )
            ->make(true);
        }
	      
        
    
  
  	}

    public function create()
    {
    	$employee = Employee::all();
    	$allowance = Allowance::all();
        return view('backend.employee_allowance.create', ['employee'=>$employee, 'allowance'=>$allowance]);
    }

    public function store(Request $request)
    { 
    	$dt = Carbon::now();
	    $date = $dt->toDateString();
	    $list = Salary::latest()->first();

	    if($list){
	    	$list = $list->list + 1;
	    }
		else{
			$list = 0;
		}

    	 $salary = DB::table('employees')
            ->join('presences', 'presences.employee_id', '=', 'employees.id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.id as employee_id','employees.name', DB::raw('count(presences.employee_id) as total_presences'), DB::raw('count(presences.employee_id)*positions.salary as total_salary'), DB::raw('sum(positions.transport) as total_transport'), DB::raw('sum(presences.overtime)*20000 as total_overtime'), DB::raw('(count(presences.employee_id)*positions.salary) + sum(positions.transport) + (sum(presences.overtime)*20000) as total_all'))
            ->groupBy('employees.id')
            ->whereMonth('presences.date', '=', date('m'))
            ->get();

          foreach($salary as $row){
          $data = [
                'employee_id' => $row->employee_id,
                'salary' => $row->total_salary,
                'total_presences' => $row->total_presences,
                'total_transport' => $row->total_transport,
                'total_overtime' => $row->total_overtime,
                'total_salary' => $row->total_all
                ];

          $new_salary =  new Salary();
      		$new_salary->employee_id = $data['employee_id'];
      		$new_salary->month = $dt->month;
      		$new_salary->years = $dt->year;
      		$new_salary->list = $list;
      		$new_salary->salary = $data['salary'];
          $new_salary->total_presences = $data['total_presences'];
      		$new_salary->total_transport = $data['total_transport'];
      		$new_salary->total_overtime = $data['total_overtime'];
      		$new_salary->total_salary = $data['total_salary'];
      		$new_salary->save();
          }
      	

      session()->flash('message', 'Anda berhasil membuat gaji bulan ini.');

     return redirect('/admin/salary');
    }

    public function printHistorySalary($history)
    { 
      // $salary = Salary::where('history', $history)->get();

      $salary = DB::table('salaries')
            ->join('employees', 'employees.id', '=', 'salaries.employee_id')
            ->select('employees.name as employee_name', 'salaries.*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->groupBy('salaries.employee_id')
            ->where('salaries.list', '=', $history)
            ->get();

      $total = DB::table('salaries')
            ->select( DB::raw('sum(salaries.total_salary) as total_all'), 'salaries.*')
            ->groupBy('salaries.created_at')
            ->where('salaries.list', '=', $history)
            ->first();

        $pdf = PDF::loadView('backend/pdf/payroll', ['salary' => $salary, 'total' => $total]);
        return $pdf->stream('Payroll_'.$total->month.'_'.$total->years.'.pdf');
    }

    public function searchSalary(Request $request)
    {
        $month = $request->month;
        $year = $request->years;

        if($month==0){
            $salary = Salary::select('*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->where('years', $year)
            ->groupBy('list')
            ->get();
        }
      elseif($year==0){
            $salary = Salary::select('*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->where('month', $month)
            ->groupBy('list')
            ->get();
      }
      else{
      $salary = Salary::select('*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->where('month', $month)
            ->where('years', $year)
            ->groupBy('list')
            ->get();
      }
        if ($salary){
          session()->flash('salary_found', true);
        }
        else{
          session()->flash('salary_not_found', true);
        }
        
        return view('backend.salary.history', ['salary'=>$salary]);
    }

    // public function show(Request $request)
    // {
    //     $month = $request->month;
    //     $year = $request->years;

    //     $salary = Salary::select('*', DB::raw('sum(salaries.total_salary) as total_all'))
    //     ->where('month', $month)
    //     ->where('years', $year)
    //     ->groupBy('list')
    //     ->get();

    //     if ($salary){
    //       session()->flash('salary_found', true);
    //     }
    //     else{
    //       session()->flash('salary_not_found', true);
    //     }
        
    //     return view('backend.salary.search', ['salary'=>$salary]);
    // }

}
