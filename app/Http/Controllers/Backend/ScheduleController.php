<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Schedule;
use App\Month;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Genetic;

use Yajra\Datatables\Datatables;

use Auth;
use DB;
use Carbon\Carbon;
use PDF;

class ScheduleController extends Controller
{

	public function index()
    {
        return view('backend.schedule.index');
    }

  	public function getIndex()
    {
        return view('backend.schedule.index');
    }

    public function getSchedulesEmployee()
    {
        return view('backend.schedule.employee_index');
    }

    public function getList()
    { 
      $years = DB::table('schedules')
      ->select('schedules.year')
            ->groupBy('schedules.year')
            ->orderBy('schedules.year', 'desc')
            ->get();

      $schedule = DB::table('schedules')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('months.name as month_name', 'schedules.*')
            ->groupBy('schedules.month_id')
            ->groupBy('schedules.year')
            ->orderBy('schedules.created_at', 'desc')
            ->get();
            // ->whereMonth('presences.date', '=', $dt->month);
        return view('backend.schedule.history', ['schedule'=>$schedule, 'years'=>$years]);
    }


	public function dataSchedules()
  	{ 
    	 $schedules = DB::table('schedules')
            ->join('employees', 'employees.id', '=', 'schedules.employee_id')
            ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
            ->join('days', 'days.id', '=', 'schedules.day_id')
            ->join('weeks', 'weeks.id', '=', 'schedules.week_id')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'employees.name as employee_name', 'shifts.name as shift_name', 'days.name as day_name', 'weeks.name as week_name', 'months.name as month_name');

	      return Datatables::of($schedules)
	      ->addColumn('action', function ($schedules) {
                return '<a href="'.url('admin/schedule/'. $schedules->id .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>
                
                <form method="POST" action="'.url('admin/schedule/'. $schedules->id).'" style="display: inline">  
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' .csrf_token(). '">
                        <button class="btn-sm btn-danger" type="submit" style="border: none"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</button>
                 </form>';
            }
            )
            ->make(true);  
  	}

  	public function dataSchedulesEmployee()
  	{	
  		$user = Auth::id();
        $dt = Carbon::now();
        $date = $dt->toDateString();

    	 $schedules = DB::table('schedules')
            ->join('employees', 'employees.id', '=', 'schedules.employee_id')
            ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
            ->join('days', 'days.id', '=', 'schedules.day_id')
            ->join('weeks', 'weeks.id', '=', 'schedules.week_id')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'employees.name as employee_name', 'shifts.name as shift_name', 'days.name as day_name', 'weeks.name as week_name', 'months.name as month_name')
            ->where('employees.id', '=', $user)
            ->where('schedules.month_id', '=', $dt->month);


	      return Datatables::of($schedules)->make(true);  
  	}

    public function create()
    {
    	$month = Month::all();
        return view('backend.schedule.create', ['month'=>$month]);
    }

    public function store(Request $request)
    {   
      $user = Auth::id();
      $month = $request->month;
      $schedule_week = $request->schedule_week;
      $jumlah_populasi = $request->jumlah_populasi;
      $crossOver = $request->probabilitas_crossover;
      $mutasi = $request->probabilitas_mutasi;
      $jumlah_generasi = $request->jumlah_generasi;
      $year = Carbon::now()->year;

      $data['month'] = $month;
      $data['schedule_week'] = $schedule_week;
	    $data['jumlah_populasi'] = $jumlah_populasi;
	    $data['probabilitas_crossover'] = $crossOver;
	    $data['probabilitas_mutasi'] = $mutasi;
	    $data['jumlah_generasi'] = $jumlah_generasi;

      $list_schedule = Schedule::latest()->first();

      if($list_schedule){
        if($list_schedule->month_id == $month && $list_schedule->year == $year){
          $list = $list_schedule->list;
        }
        else{
          $list = $list_schedule->list + 1;
        }
      }
      else{
        $list = 0;
      }

      $data['month'] = $month;
	    $genetik = new Genetic($month,$schedule_week,$jumlah_populasi,$crossOver,$mutasi,$jumlah_generasi);
					
	    $genetik->AmbilData();
	    $genetik->Inisialisai();
					
					$found = false;
					
					for($i = 0;$i < $jumlah_generasi;$i++ ){
						$fitness = $genetik->HitungFitness();
						
						//if($i == 100){
						//	var_dump($fitness);
						//	exit();
						//}
						
						$genetik->Seleksi($fitness);
						$genetik->StartCrossOver();
						
						$fitnessAfterMutation = $genetik->Mutasi();

						
						for ($j = 0; $j < count($fitnessAfterMutation); $j++){
							//test here
							if($fitnessAfterMutation[$j] == 1){
								
								// $schedule_del = Schedule::all();
    				// 			$schedule_del ->truncate();
								
								$jadwal_kuliah = array(array());
								$jadwal_kuliah = $genetik->GetIndividu($j);
								
								
								
								for($k = 0; $k < count($jadwal_kuliah);$k++){
									
									$week_id = intval($jadwal_kuliah[$k][0]);
									$shift_id = intval($jadwal_kuliah[$k][1]);
									$employee_id = intval($jadwal_kuliah[$k][2]);
									$day_id = intval($jadwal_kuliah[$k][3]);
									
									$schedule =  new Schedule();
									$status = 1;

							        $schedule->employee_id = $employee_id;
							        $schedule->shift_id = $shift_id;
							        $schedule->day_id = $day_id;
							        $schedule->week_id = $week_id;
                      $schedule->month_id = $month;
                      $schedule->year = $year;
							        $schedule->list = $list;
							        $schedule->status = $status;
							        $schedule->save();									
								}
								
								//var_dump($jadwal_kuliah);
								//exit();
								
								$found = true;								
							}
							
							if($found){break;}
						}
						
						if($found){break;}
					}
					
					if(!$found){
						$data['msg'] = 'Tidak Ditemukan Solusi Optimal';
					}

      session()->flash('message', 'Anda berhasil membuat jadwal.');

     return redirect('/admin/schedule');
    }


    public function edit($id)
    {
        $position = Position::find($id);

        return view('backend.position.edit')->with('position', $position);
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::id();

        $position = Position::find($id);
        $this->validate($request,$position->rules);
        $position->fill($request->all());
        $position->user_id = $user;
        $position->save();

        session()->flash('message', 'Data jabatan berhasil diperbarui.');

        return redirect('/admin/position');
    }

    public function destroy($id)
  	{
  		Schedule::find($id)->delete();

          session()->flash('message', 'Data jabatan berhasil dihapus.');

  		return redirect('/admin/position');
  	}

    public function printHistorySchedule($history)
    { 
      $dt = Carbon::now();
      $date = $dt->toDateString();

      $schedule = DB::table('schedules')
            ->join('employees', 'employees.id', '=', 'schedules.employee_id')
            ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
            ->join('days', 'days.id', '=', 'schedules.day_id')
            ->join('weeks', 'weeks.id', '=', 'schedules.week_id')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'employees.name as employee_name', 'shifts.name as shift_name', 'days.name as day_name', 'weeks.name as week_name', 'months.name as month_name')
            ->where('schedules.list', '=', $history)
            ->orderBy('schedules.week_id', 'asc')
            ->get();

      $spec_schedule = DB::table('schedules')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'months.name as month_name')
            ->where('schedules.list', '=', $history)
            ->first();

        $pdf = PDF::loadView('backend/pdf/schedule', ['schedule' => $schedule, 'spec_schedule' => $spec_schedule, 'date' => $date]);
        return $pdf->stream('Schedule_'.$spec_schedule->month_id.'_'.$spec_schedule->year.'.pdf');
    }

    public function searchSchedule(Request $request)
    {
        $month = $request->month;
        $year = $request->years;

        $years = DB::table('schedules')
        ->select('schedules.year')
            ->groupBy('schedules.year')
            ->orderBy('schedules.year', 'desc')
            ->get();

        if($month==0){
            $schedule = DB::table('schedules')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'months.name as month_name')
            ->where('year', $year)
            ->groupBy('list')
            ->get();
        }
        elseif($year==0){
            $schedule = DB::table('schedules')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'months.name as month_name')
            ->where('month_id', $month)
            ->groupBy('list')
            ->get();
        }
        else{
            $schedule = DB::table('schedules')
            ->join('months', 'months.id', '=', 'schedules.month_id')
            ->select('schedules.*', 'months.name as month_name')
            ->where('month_id', $month)
            ->where('year', $year)
            ->groupBy('list')
            ->get();
        }
        if ($schedule){
          session()->flash('schedule_found', true);
        }
        else{
          session()->flash('schedule_not_found', true);
        }
        
        return view('backend.schedule.history', ['schedule'=>$schedule, 'years'=>$years]);
    }

}
