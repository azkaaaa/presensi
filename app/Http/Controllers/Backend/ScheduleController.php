<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\User;
use App\Schedule;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\Genetic;

use Yajra\Datatables\Datatables;

use Auth;

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


	public function dataSchedules()
  	{
    	 $schedules = Schedule::select(['id', 'employee_id', 'shift', 'day', 'date', 'status', 'created_at', 'updated_at']);

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


    public function create()
    {
        return view('backend.schedule.create');
    }

    public function store(Request $request)
    {   
      $user = Auth::id();

      // $position =  new Position();
      // // $this->validate($request,$position->rules);
      // $position->fill($request->all());
      // $position->user_id = $user;
      // $position->save();

      $month = $request->month;
      $jumlah_populasi = $request->jumlah_populasi;
      $crossOver = $request->probabilitas_crossover;
      $mutasi = $request->probabilitas_mutasi;
      $jumlah_generasi = $request->jumlah_generasi;

      $data['month'] = $month;
	  $data['jumlah_populasi'] = $jumlah_populasi;
	  $data['probabilitas_crossover'] = $crossOver;
	  $data['probabilitas_mutasi'] = $mutasi;
	  $data['jumlah_generasi'] = $jumlah_generasi;

	  $genetik = new Genetic($month,$jumlah_populasi,$crossOver,$mutasi,$jumlah_generasi);
					
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
									
									$employee_id = intval($jadwal_kuliah[$k][0]);
									$time_id = intval($jadwal_kuliah[$k][1]);
									$day_id = intval($jadwal_kuliah[$k][2]);
									
									$schedule =  new Schedule();
									$status = 1;
							    
							        $schedule->employee_id = $employee_id;
							        $schedule->shift = $time_id;
							        $schedule->day = $day_id;
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

}
