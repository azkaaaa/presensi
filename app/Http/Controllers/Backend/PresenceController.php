<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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

    public function getDoPresence()
    {
        return view('backend.presence.presence');
    }

    public function getPresence()
    {
        return view('backend.presence.index');
    }

    public function dataPresences()
  	{
    	 $oresences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('presences.*', 'employees.name as employee_name', 'positions.name as position_name');

	      return Datatables::of($oresences)
	      ->addColumn('action', function ($oresences) {
                return '<a href="'.url('admin/presence/'. $oresences->id).'" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detail</a>

                		<a href="'.url('admin/presence/'. $oresences->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Lembur</a>';
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
      $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));
	 
      if($employee){

      $have_presence = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date)->first();

	  	$have_presence_two = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date_two)
	    ->where('time_in', '>=', '15:00')->first();

      $have_overtime = DB::table('presences')
      ->where('employee_id', $employee->id)
      ->where('date', $date)
      ->where('overtime_permit', 'Y')->first();

        //PULANG
      if($have_presence_two AND $have_overtime AND $time <= '08:00'){
           $shift = 2;
           $info = 'Masuk';
           $date = $date->additional;
           $additional = $presence->additional;
           $presence->time_out = $time;
           $overtime = $presence->overtime;
           $overtime_status = $presence->overtime_status;
           $overtime_permit = $presence->overtime_permit;

            session()->flash('return_presence_normal_success_on',$employee->name);
            session()->flash('return_presence_overtime_success_on', $presence->overtime);
        }
        //PULANG
      elseif($have_presence AND $have_overtime AND $time >= '17:00'){
           $shift = 1;
           $info = 'Masuk';
           $additional = $presence->additional;
           $presence->time_out = $time;
           $overtime = $presence->overtime;
           $overtime_status = $presence->overtime_status;
           $overtime_permit = $presence->overtime_permit;

            session()->flash('return_presence_success_on',$employee->name); 
            session()->flash('return_presence_overtime_success_on', $presence->overtime); 
        }
        //PULANG
      elseif($have_presence AND $time >= '17:00'){
           $shift = 1;
           $info = 'Masuk';
           $additional = $presence->additional;
           $presence->time_out = $time;
           $overtime = $presence->overtime;
           $overtime_status = $presence->overtime_status;
           $overtime_permit = $presence->overtime_permit;

            session()->flash('return_presence_normal_success_on',$employee->name);
        }
        //PULANG
      elseif($have_presence_two AND $time <= '08:00'){
           $shift = 2;
           $info = 'Masuk';
           $date = $presence->date;
           $additional = $presence->additional;
           $presence->time_out = $time;
           $overtime = $presence->overtime;
           $overtime_status = $presence->overtime_status;
           $overtime_permit = $presence->overtime_permit;

            session()->flash('return_presence_normal_success_on',$employee->name);
        }
        //MASUK
      elseif($time <= '07:00'){
      		 $shift = 1;
      		 $info = 'Masuk';
      		 $additional = 'Tepat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_on',$employee->name);
      	}
        //MASUK
      elseif($time > '07:00' AND $time <= '10:00'){
      		 $shift = 1;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_late',$employee->name);
      	}
        //MASUK
      elseif($time > '15:00' AND $time <= '17:00'){
      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Tepat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('return_presence_success_on',$employee->name);
      	}
        //MASUK
      elseif($time > '17:00' AND $time <= '20:00'){
      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_late',$employee->name);
      	}
	      
	      $presence->employee_id = $employee->id;
	      $presence->date = $date;
	      $presence->shift = $shift;
	      $presence->info = $info;
        $presence->additional = $additional;
        $presence->overtime = $overtime;
        $presence->overtime_status = $overtime_status;
	      $presence->overtime_permit = $overtime_permit;
	      $presence->save();
	     
	     return redirect('/presence');
      }
	  else{
          session()->flash('presence_failed',true);
	  	  
	     return redirect()->route('user.presence.index');
	  }      
    }

    public function edit($id)
    {
        $presence = Presence::find($id);
        $employee_id = $presence->employee->id;
        $employee = Employee::find($employee_id);
        $position_id = $employee->position->id;
        $position = Position::find($position_id);

        return view('backend.presence.edit', ['employee'=>$employee, 'position'=>$position, 'presence'=>$presence]);
    }
    
    public function update(Request $request, $id)
    {
        // $user = Auth::id();
        $overtime_permit = 'Y';
        $overtime_status = 'Lembur';
        $presence = presence::find($id);
        $this->validate($request,$presence->rules);
        $presence->overtime = $request->overtime;
        $presence->overtime_status = $overtime_status;
        $presence->overtime_permit = $overtime_permit;
        $presence->save();

        session()->flash('message', 'Karyawan berhasil diberikan lembur.');

        return redirect('/admin/presence/data');
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
