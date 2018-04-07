<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Employee;
use App\Allowance;
use App\EmployeeAllowance;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use DB;

class EmployeeAllowanceController extends Controller
{

	public function index()
    {
        return view('backend.employee_allowance.index');
    }

  public function getIndex()
    {
        return view('backend.employee_allowance.index');
    }


	public function dataEmpAllowance()
  	{
    	 $empallowance = DB::table('employee_allowances')
            ->join('employees', 'employees.id', '=', 'employee_allowances.employee_id')
            ->join('allowances', 'allowances.id', '=', 'employee_allowances.allowance_id')
            ->select('employee_allowances.*', 'employees.name as employee_name', 'allowances.name as allowance_name', 'allowances.price as allowance_price');

	      return Datatables::of($empallowance)
	      ->addColumn('action', function ($empallowance) {
                return '<a href="'.url('admin/empallowance/'. $empallowance->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/empallowance/'. $empallowance->id).'" style="display: inline">  
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
      $employee_allowance =  new EmployeeAllowance();
      $this->validate($request,$employee_allowance->rules);
      $employee_allowance->fill($request->all());
      $employee_allowance->save();

      session()->flash('message', 'Anda berhasil menambahkan data tunjangan karyawan.');

     return redirect('/admin/empallowance');
    }


    public function edit($id)
    {
        $employee_allowance = EmployeeAllowance::find($id);
        $employee = Employee::all();
    	$allowance = Allowance::all();
        return view('backend.employee_allowance.edit', ['employee_allowance'=>$employee_allowance,'employee'=>$employee, 'allowance'=>$allowance]);
    }
    
    public function update(Request $request, $id)
    {
        // $user = Auth::id();

        $employee_allowance = EmployeeAllowance::find($id);
        $this->validate($request,$employee_allowance->rules);
        $employee_allowance->fill($request->all());
        $employee_allowance->save();

        session()->flash('message', 'Data tunjangan karyawan diperbarui.');

        return redirect('/admin/empallowance');
    }

    public function destroy($id)
  	{
  		EmployeeAllowance::find($id)->delete();

          session()->flash('message', 'Data tunjangan karyawan berhasil dihapus.');

  		return redirect('/admin/empallowance');
  	}

}
