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

        return view('backend.salary.index', ['salary'=>$salary]);
    }

  public function getList()
    {
    	$salary = DB::table('salaries')
            ->join('employees', 'employees.id', '=', 'salaries.employee_id')
            ->select('employees.name as employee_name', 'salaries.*', DB::raw('sum(salaries.total_salary) as total_all'))
            ->groupBy('salaries.created_at')
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
            ->join('employee_allowances', 'employee_allowances.employee_id', '=', 'employees.id')
            ->join('allowances', 'allowances.id', '=', 'employee_allowances.allowance_id')
            ->select('employees.*', DB::raw('count(presences.employee_id)*positions.salary as total_salary'), DB::raw('sum(allowances.price) as total_allowance'), DB::raw('sum(presences.overtime)*20000 as total_overtime'), DB::raw('(count(presences.employee_id)*positions.salary) + sum(allowances.price) + (sum(presences.overtime)*20000) as total_all'))
            ->groupBy('employees.id')
            ->whereMonth('presences.date', '=', $dt->month);

	      return Datatables::of($salary)
	      ->addColumn('action', function ($salary) {
                return '<a href="'.url('admin/salary/'. $salary->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/salary/'. $salary->id).'" style="display: inline">  
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' .csrf_token(). '">
                        <button class="btn-sm btn-danger" type="submit" style="border: none"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
                 </form>';
            }
            )
            ->make(true);
    
  
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
            ->join('employee_allowances', 'employee_allowances.employee_id', '=', 'employees.id')
            ->join('allowances', 'allowances.id', '=', 'employee_allowances.allowance_id')
            ->select('employees.id as employee_id','employees.name', DB::raw('count(presences.employee_id)*positions.salary as total_salary'), DB::raw('sum(allowances.price) as total_allowance'), DB::raw('sum(presences.overtime)*20000 as total_overtime'), DB::raw('(count(presences.employee_id)*positions.salary) + sum(allowances.price) + (sum(presences.overtime)*20000) as total_all'))
            ->groupBy('employees.id')
            ->whereMonth('presences.date', '=', date('m'))
            ->get();

          foreach($salary as $row){
          $data = [
                'employee_id' => $row->employee_id,
                'salary' => $row->total_salary,
                'total_allowance' => $row->total_allowance,
                'total_overtime' => $row->total_overtime,
                'total_salary' => $row->total_all
                ];

          	$new_salary =  new Salary();
      		$new_salary->employee_id = $data['employee_id'];
      		$new_salary->month = $dt->month;
      		$new_salary->years = $dt->year;
      		$new_salary->list = $list;
      		$new_salary->salary = $data['salary'];
      		$new_salary->total_allowance = $data['total_allowance'];
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
            ->where('salaries.history', '=', $history)
            ->get();

      $total = DB::table('salaries')
            ->select( DB::raw('sum(salaries.total_salary) as total_all'), 'salaries.*')
            ->groupBy('salaries.created_at')
            ->where('salaries.history', '=', $history)
            ->first();

        $pdf = PDF::loadView('backend/pdf/payroll', ['salary' => $salary, 'total' => $total]);
        return $pdf->stream('Payroll_'.Carbon::parse($total->created_at)->format('F').'_'.Carbon::parse($total->created_at)->format('Y').'.pdf');
    }

    public function searchSalary(Request $request)
    {
        $month = $request->month;
        $years = $request->years;

        $salary = Salary::whereMonth('created_at', $month)->get();

        return view('backend.salary.search', ['salary'=>$salary]);
    }

    public function show(Request $request)
    {
        $month = $request->month;
        $year = $request->years;

        $salary = Salary::where('month', $month)->where('years', $year)->get();

        return view('backend.salary.search', ['salary'=>$salary]);
    }

}
