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

  public function getIndex()
    {
        return view('backend.salary.index');
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
      		$new_salary->salary = $data['salary'];
      		$new_salary->total_allowance = $data['total_allowance'];
      		$new_salary->total_overtime = $data['total_overtime'];
      		$new_salary->total_salary = $data['total_salary'];
      		$new_salary->save();
          }
      	

      session()->flash('message', 'Anda berhasil membuat gaji bulan ini.');

     return redirect('/admin/salary');
    }


    public function destroy($id)
  	{
  		Salary::find($id)->delete();

          session()->flash('message', 'Data gaji berhasi dihapus.');

  		return redirect('/admin/empallowance');
  	}

}
