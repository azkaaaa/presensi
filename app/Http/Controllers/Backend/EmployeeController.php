<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Employee;
use App\Position;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use DB;

class EmployeeController extends Controller
{

  public function index()
    {
        return view('backend.employee.index_employee');
    }

  public function getIndex()
    {
        return view('backend.employee.index_employee');
    }

  public function getEmployees()
    {
        return view('backend.employee.manager_index');
    }


  public function dataEmployees()
    {
      $employees = DB::table('employees')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.*', 'positions.name as position_name');

        return Datatables::of($employees)
        ->addColumn('action', function ($employees) {
                return '<a href="'.url('admin/employee/'. $employees->id).'" class="btn-sm btn-info"> Detail</a>

                    <a href="'.url('admin/employee/'. $employees->id .'/edit').'" class="btn-sm btn-primary"> Edit</a>';
            }
            )
            ->make(true);
    
  
    }

    public function dataEmployeesManager()
    {
      $employees = DB::table('employees')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.*', 'positions.name as position_name');

        return Datatables::of($employees)
        ->addColumn('action', function ($employees) {
                return '<a href="'.url('manager/detailemployee/'. $employees->id).'" class="btn btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detail</a>';
            }
            )
            ->make(true);
    
  
    }

    public function show($id){
        //select * from tugas where id=$id
        // $data = School::find($id);
        $employee = DB::table('employees')
        ->where('employees.id', $id)
        ->join('users', 'users.id', '=','employees.user_id')
        ->join('positions', 'positions.id', '=','employees.position_id')
        ->select('employees.name','employees.nik','employees.id_card','employees.birthday','employees.address','employees.phone','employees.account_number','employees.profile_picture','positions.name as position_name','users.email','users.level','users.status')
        ->first();
        return view('backend.employee.detail')->with('employee', $employee);
    }

    public function getDetailEmployee($id){
        //select * from tugas where id=$id
        // $data = School::find($id);
        $employee = DB::table('employees')
        ->where('employees.id', $id)
        ->join('users', 'users.id', '=','employees.user_id')
        ->join('positions', 'positions.id', '=','employees.position_id')
        ->select('employees.name','employees.nik','employees.id_card','employees.birthday','employees.address','employees.phone','employees.account_number','employees.profile_picture','positions.name as position_name','users.email','users.level','users.status')
        ->first();
        return view('backend.employee.manager_detail')->with('employee', $employee);
    }


    public function create()
    {
      $position = Position::all();
        return view('backend.employee.create', ['position'=>$position]);
    }

    public function store(Request $request)
    {   
      // $user = Auth::id();
      $status = '1';
      $user =  new User();
      $employee =  new Employee();
      $registration_rules = array_merge($user->rules,$employee->rules);

      $this->validate($request,$registration_rules);

      $user->fill($request->all());
      $password = Hash::make($request->password);
      $user->password = $password;
      $user->status = $status;
      $user->save();

      $employee->fill($request->all());
      $employee->user_id = $user->id;
      $employee->save();

      session()->flash('message', 'Anda berhasil menambahkan data karyawan.');

     return redirect('/admin/employee');
    }


    public function edit($id)
    { 
        $employee = Employee::find($id);
        $user_id = $employee->user->id;
        $user = User::find($user_id);
        $position = Position::all();

        return view('backend.employee.edit', ['employee'=>$employee, 'position'=>$position, 'user'=>$user]);
    }
    
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $user_id = $employee->user->id;
        $user = User::find($user_id);

        $status = $request->status;
        $registration_rules = array_merge($user->update_rules($user_id),$employee->update_rules($id));

        $this->validate($request,$registration_rules);

        $user->fill($request->all());
        $password = Hash::make($request->password);
        $user->password = $password;
        $user->status = $status;
        $user->save();

        $employee->fill($request->all());
        $employee->user_id = $user->id;
        $employee->save();

        session()->flash('message', 'Data jabatan berhasil diperbarui.');

        return redirect('/admin/employee');
    }

    public function destroy($id)
    {
      Employee::find($id)->delete();

          session()->flash('message', 'Data jabatan berhasil dihapus.');

      return redirect('/admin/employee');
    }

}
