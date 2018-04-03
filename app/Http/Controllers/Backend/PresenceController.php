<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Employee;
use App\Position;
use App\Presence;
use App\Capture;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use DB;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function index()
    {
        return view('backend.presence.presence');
    }

    public function dataPresences()
  	{
    	 $employees = Employee::select(['id', 'name', 'nik', 'id_card', 'birthday', 'religion', 'address', 'phone', 'education', 'account_number', 'position_id', 'created_at', 'updated_at']);

	      return Datatables::of($employees)
	      ->addColumn('action', function ($employees) {
                return '<a href="'.url('admin/employee/'. $employees->id).'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detail</a>

                		<a href="'.url('admin/employee/'. $employees->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
		                <form method="POST" action="'.url('admin/employee/'. $employees->id).'" style="display: inline">  
		                        <input type="hidden" name="_method" value="DELETE">
		                        <input type="hidden" name="_token" value="' .csrf_token(). '">
		                        <button class="btn-sm btn-danger" type="submit" style="border: none"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
		                 </form>';
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
        ->select('employees.name','employees.nik','employees.id_card','employees.birthday','employees.religion','employees.address','employees.phone','employees.education','employees.account_number','positions.name as position_name','users.email','users.level','users.status')
        ->first();
        return view('backend.presence.detail')->with('employee', $employee);
    }


    // public function create()
    // {
    // 	$position = Position::all();
    //     return view('backend.employee.create', ['position'=>$position]);
    // }

    public function store(Request $request)
    {   
      $dt = Carbon::now();
      $dt_two = Carbon::now()->subDays(1);
	  $date = $dt->toDateString();               // 2015-12-19
	  $date_two = $dt_two->toDateString();               // 2015-13-19
	  $time = $dt->toTimeString();               // 10:10:16
	  // $dt->toFormattedDateString();      // Dec 19, 2015
	  // $dt->toDateTimeString();           // 2015-12-19 10:10:16
	  // $dt->toDayDateTimeString();
      $employee = Employee::where('id_card',$request->id_card)->first();
	 
      if($employee){

      	$have_presence = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date)->first();

	  	$have_presence_two = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date_two)
	    ->where('time', '>=', '15:00')->first();

      	if($have_presence_two AND $time <= '08:00'){
      		 $shift = 2;
      		 $info = 'Pulang';
      		 $additional = '-';
          	session()->flash('return_presence_success_on',$employee->name);
      	}
      elseif($time <= '07:00'){
      		 $shift = 1;
      		 $info = 'Masuk';
      		 $additional = 'Tepat';
          	session()->flash('presence_success_on',$employee->name);
      	}
      elseif($time > '07:00' AND $time <= '10:00'){
      		 $shift = 1;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
          	session()->flash('presence_success_late',$employee->name);
      	}
      elseif($have_presence AND $time >= '17:00'){
      		 $shift = 1;
      		 $info = 'Pulang';
      		 $additional = '-';
          	session()->flash('return_presence_success_on',$employee->name);
      	}
      elseif($time > '15:00' AND $time <= '17:00'){
      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Tepat';
          	session()->flash('return_presence_success_on',$employee->name);
      	}
      elseif($time > '17:00' AND $time <= '20:00'){
      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
          	session()->flash('presence_success_late',$employee->name);
      	}
      
	      $presence =  new Presence();
	      $presence->employee_id = $employee->id;
	      $presence->time = $time;
	      $presence->date = $date;
	      $presence->shift = $shift;
	      $presence->info = $info;
	      $presence->additional = $additional;
	      $presence->save();
	     
	     return redirect('/presence');
      }
	  else{
          session()->flash('presence_failed',true);
	  	  
	     return redirect('/presence');
	  }      
    }

    public function getCapture()
    {
        return view('backend.presence.capture');
    }

    public function postCapture(Request $request)
    {
       	$requestData = $request->all();
 
            if(!empty($_POST['namafoto'])){
                  $encoded_data = $_POST['namafoto'];
                    $binary_data = base64_decode( $encoded_data );
 
                    // save to server (beware of permissions // set ke 775 atau 777)
                    $namafoto = uniqid().".png";
                    $result = file_put_contents( 'photos/shares/'.$namafoto, $binary_data );
                    if (!$result) die("Could not save image!  Check file permissions.");
                }
        $employee = new Capture;
        $employee->namafoto = $namafoto;
        $employee->save();

  		return redirect()->route('user.profile.index');
    }
}
