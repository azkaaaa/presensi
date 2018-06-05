<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\User;
use App\Employee;
use App\Position;
use App\Presence;
use App\Capture;
use App\Month;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use Auth;
use DB;
use PDF;
use Carbon\Carbon;

class PresenceController extends Controller
{ 
    private $presence_id;

    public function index()
    {
        return view('backend.presence.presencesss');
    }

    public function getDoPresence()
    {
        return view('backend.presence.presencesss');
    }

    public function getPresence()
    {
        return view('backend.presence.index');
    }

    public function getPresencesEmployee()
    {
        $dt = Carbon::now();
        return view('backend.presence.employee_index', ['dt'=>$dt]);
    }

    public function getList()
    {
      // dd($this->presence_id);

      $years = DB::table('presences')
      ->select(DB::raw('YEAR(presences.date) year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

      $presence = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->select('employees.name as employee_name', 'presences.*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),  DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'), DB::raw('sum(presences.overtime) as total_overtime'))
            ->groupby('year','month')
            ->orderBy('presences.date', 'desc')
            ->get();

        return view('backend.presence.history', ['presence'=>$presence, 'years'=>$years]);
    }

    public function dataPresences()
  	{

    	 $presences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('presences.*', DB::raw("DATE_FORMAT(presences.date, '%d %M %Y') new_date"), 'employees.name as employee_name', 'positions.name as position_name')
            ->orderBy('presences.date', 'desc');

	      return Datatables::of($presences)
	      ->addColumn('action', function ($presences) {

                $dt = Carbon::now();
                $date = $dt->toDateString();

                if ($presences->date == $date){
                    return '<a href="'.url('admin/presence/'. $presences->id).'" class="btn btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detail</a>
                  
                    <a href="'.url('admin/presence/'. $presences->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Lembur</a>';
                }
                else{
                    return '<a href="'.url('admin/presence/'. $presences->id).'" class="btn btn-info"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Detail</a>';
                }                
            }
            )
            ->make(true);
  	}

    public function dataPresencesEmployee()
    {
       $user = Auth::id();
       $dt = Carbon::now();
       $date = $dt->toDateString(); 

       $presences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('presences.*', 'employees.name as employee_name', 'positions.name as position_name')
            ->where('employees.id', '=', $user)
            ->whereMonth('presences.date', '=', $dt->month);
          
        return Datatables::of($presences)->make(true);
    }

  	public function show($id){
        $presence = DB::table('presences')
        ->where('presences.id', $id)
        ->join('employees', 'employees.id', '=','presences.employee_id')
        ->join('positions', 'positions.id', '=','employees.position_id')
        ->select('presences.*','employees.name as employee_name','positions.name as position_name')
        ->first();

        return view('backend.presence.detail')->with('presence', $presence);
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
      //dd($date_two);
      $employee = Employee::where('id_card',$request->id_card)->first();
	 
      if($employee){

      $have_presence = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date)->first();

	  	$have_presence_two = DB::table('presences')
	    ->where('employee_id', $employee->id)
	    ->where('date', $date_two)
	    ->where('time_in', '>=', '17:00')->first();

      $have_overtime = DB::table('presences')
      ->where('employee_id', $employee->id)
      ->where('date', $date)
      ->where('overtime_permit', 'Y')->first();

        //PULANG
      if($have_presence_two AND $have_overtime AND $time <= '09:00'){
           
           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date_two));

           $shift = 2;
           $info = 'Masuk';
           $date = $presence->date;
           $additional = $presence->additional;
           $presence->time_out = $time;
           $overtime = $presence->overtime;
           $overtime_status = $presence->overtime_status;
           $overtime_permit = $presence->overtime_permit;

            session()->flash('return_presence_normal_success_on',$employee->name);
            session()->flash('return_presence_overtime_success_on', $presence->overtime);
        }
        //PULANG
      elseif($have_presence AND $have_overtime AND $time >= '20:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

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
      elseif($have_presence AND $time >= '20:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

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
      elseif($have_presence_two AND $time <= '09:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date_two));

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
      elseif($time <= '08:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

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
      elseif($time > '08:00' AND $time <= '12:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

      		 $shift = 1;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_late',$employee->name);
      	}
         //OTHERS
      elseif($time > '13:00' AND $time <= '17:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

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
      elseif($time > '17:00' AND $time <= '20:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Tepat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_on',$employee->name);
      	}
        //MASUK
      elseif($time > '20:00' AND $time <= '24:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));

      		 $shift = 2;
      		 $info = 'Masuk';
      		 $additional = 'Terlambat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

          	session()->flash('presence_success_late',$employee->name);
      	}

        //OTHER
      elseif($time > '24:00' AND $time <= '08:00'){

           $presence = Presence::firstOrNew(array('employee_id' => $employee->id, 'date' => $date));
        
           $shift = 2;
           $info = 'Masuk';
           $additional = 'Terlambat';
           $overtime = '0';
           $overtime_status = 'N';
           $overtime_permit = 'N';
           $presence->time_in = $time;

            session()->flash('presence_success_late',$employee->name);
        }

        // $filename = time() .'.jpg';

        // $upload_result = $request->file('webcam')->move(public_path().'/admin/uploads/presence/', $filename);

       
       // dd($capture->picture);
       
	      
	      $presence->employee_id = $employee->id;
	      $presence->date = $date;
	      $presence->shift = $shift;
	      $presence->info = $info;
        $presence->additional = $additional;
        $presence->overtime = $overtime;
        $presence->overtime_status = $overtime_status;
        $presence->overtime_permit = $overtime_permit;
	      $presence->save();

        $capture = Capture::latest()->first();
        $presence->capture = $capture->picture;
        $presence->save();
	     
	     return redirect()->back();
      }

	  else{
          session()->flash('presence_failed',true);
	  	  
	     return redirect()->back();
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
        return view('backend.presence.captures');
    }

    public function postCapture(Request $request)
    {
        $filename = time() .'.jpg';
        $upload_result = $request->file('webcam')->move(public_path().'/admin/uploads/presence/',$filename);

        // $presence = Capture::orderBy('created_at', 'desc')->first();
   
        $presence_capture = new Capture;
        $presence_capture->picture = $filename;
        $presence_capture->save();
    
        


  		 return redirect('/admin/presence');
    }

    public function printHistoryPresence($history)
    { 
      $dt = Carbon::now();
      $date = $dt->toDateString();
      $presences = DB::table('presences')
            ->join('employees', 'employees.id', '=', 'presences.employee_id')
            ->select('employees.name as employee_name', 'presences.*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),  DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'))
            // ->groupby('year','month')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%m-%Y')"), '=', $history)
            ->get();

      $total = DB::table('presences')
            ->select('presences.*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),  DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'), DB::raw('sum(presences.overtime) as total_overtime'))
            ->groupby('year','month')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%m-%Y')"), '=', $history)
            ->first();
      $tes =  date('m',strtotime($total->date));
      
      $month = Month::find($tes);
            // dd($presences);

        $pdf = PDF::loadView('backend/pdf/presence', ['presences' => $presences, 'total' => $total, 'date' => $date, 'month' => $month->name]);
        return $pdf->stream('Absen_'.Carbon::parse($total->date)->format('F').'_'.Carbon::parse($total->date)->format('Y').'.pdf');
    }

    public function searchPresence(Request $request)
    {
        $month = $request->month;
        $year = $request->years;

        $years = DB::table('presences')
        ->select(DB::raw('YEAR(presences.date) year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        if($month==0){
            $presence = Presence::select('*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'), DB::raw('sum(presences.overtime) as total_overtime'))
            ->where(DB::raw('YEAR(presences.date)'), $year)
            ->groupby('year','month')
            ->get();
        }
        elseif($year==0){
              $presence = Presence::select('*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'),DB::raw('sum(presences.overtime) as total_overtime'))
              ->where(DB::raw('MONTH(presences.date)'), $month)
              ->groupby('year','month')
              ->get();
        }
        else{
            $presence = Presence::select('*', DB::raw("DATE_FORMAT(presences.date, '%m-%Y') new_date"),DB::raw('YEAR(presences.date) year, MONTH(presences.date) month'),DB::raw('sum(presences.overtime) as total_overtime'))
              ->where(DB::raw('YEAR(presences.date)'), $year)
              ->where(DB::raw('MONTH(presences.date)'), $month)
              ->groupby('year','month')
              ->get();
        }

        if ($presence){
          session()->flash('presence_found', true);
        }
        else{
          session()->flash('presence_not_found', true);
        }
        
        return view('backend.presence.history', ['presence'=>$presence, 'years'=>$years]);
    }
}
