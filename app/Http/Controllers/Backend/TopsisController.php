<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Employee;
use App\Alternative;
use App\AlternativeKriteria;
use App\Kriteria;
use App\TopsisResult;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Yajra\Datatables\Datatables;

use DB;
use PDF;
use Carbon\Carbon;

class TopsisController extends Controller
{
    public function index()
    {
    	$kriteria = Kriteria::all();
    	$employee = Employee::all();

    	$dt = Carbon::now();
	    $date = $dt->toDateString(); 

    	// $alternatifkriteria = DB::table('talternatif_kriteria')
     //       ->select('talternatif_kriteria.*')
     //       ->whereMonth('talternatif_kriteria.created_at', '=', $dt->month)
     //       ->where('talternatif_kriteria.id_kriteria', '=', 8)
     //       ->first();

        return view('backend.topsis.index', ['kriteria'=>$kriteria, 'employee'=>$employee]);
    }

    public function show()
    {
        return view('backend.topsis.create');
    }

    public function getKriteria()
    {
    	$kriteria = Kriteria::all();
        return view('backend.topsis.index_kriteria', ['kriteria'=>$kriteria]);
    }

    public function dataKriteria()
  	{
    	 $kriterias = Kriteria::select(['id_kriteria', 'nama_kriteria', 'kepentingan', 'costbenefit']);

	      return Datatables::of($kriterias)
	      ->addColumn('action', function ($kriterias) {
                return '<a href="'.url('admin/topsiskriteria/'. $kriterias->id_kriteria .'/edit').'" class="btn btn-primary"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a>';
            }
            )
            ->make(true);
    
  
  	}

  	public function editkriteria($id)
    {
        $kriteria = Kriteria::where('id_kriteria', $id)->first();

        return view('backend.topsis.edit_kriteria')->with('kriteria', $kriteria);
    }
    
    public function updateKriteria(Request $request, $id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->kepentingan = $request->kepentingan;
        // $this->validate($request,$kriteria->rules);
        // $kriteria->fill($request->all());
        $kriteria->save();

        session()->flash('message', 'Data kriterias berhasil diperbarui.');

        return redirect('/admin/topsiskriteria');
    }

    public function create()
    {	
    	$year =  date('Y');
    	$month =  date('m');

    	$alternatif = array(); //array("Galaxy", "iPhone", "BB", "Lumia");
	
		$dataalternatif = Employee::all();
		$i=0;
		foreach ($dataalternatif as $row) {
  			$alternatif[$i] = $row->name;
			$i++;
		}
		
		$kriteria = array(); //array("Harga", "Kualitas", "Fitur", "Populer", "Purna Jual", "Keawetan");
		
		$costbenefit = array(); //array("cost", "benefit", "benefit", "benefit", "benefit", "benefit");
		
		$kepentingan = array(); //array(4, 5, 4, 3, 3, 2);

		$datakriteria = Kriteria::all();
		$i=0;
		foreach ($datakriteria as $row) {
  			$kriteria[$i] = $row->nama_kriteria;
			$costbenefit[$i] = $row->costbenefit;
			$kepentingan[$i] = $row->kepentingan;
			$i++;
		}

		// dd($kriteria[1]);
		// while ($datakriteria)
		// {
		// 	$kriteria[$i] = $datakriteria['nama_kriteria'];
		// 	$costbenefit[$i] = $datakriteria['costbenefit'];
		// 	//$kepentingan[$i] = @$_POST['kepentingan'.$datakriteria['id_kriteria']]; //$datakriteria['kepentingan'];
		// 	$i++;
		// }
		
		$alternatifkriteria = array();
							 /* array(
								array(3500, 70, 10, 80, 3000, 36),				
								array(4500, 90, 10, 60, 2500, 48),					                           
								array(4000, 80, 9, 90, 2000, 48),												                            
								array(4000, 70, 8, 50, 1500, 60)
							  ); */

		// ini untuk dapetin nilai dari alternatif kriteria
		$dataalternatif = Employee::all();
		$i=0;
		foreach ($dataalternatif as $dataal) {
			$datakriteria = Kriteria::all();
			//dd($datakriteria);
			$j=0;
			foreach ($datakriteria as $datakr) {
				$queryalternatifkriteria = AlternativeKriteria::where('id_alternatif', $dataal->id)->where('id_kriteria', $datakr->id_kriteria)
				
				->where(DB::raw("DATE_FORMAT(created_at, '%m')"), '=', $month)
            	->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year)
            	->get();

					// $dataalternatifkriteria = mysql_fetch_array($queryalternatifkriteria);

					foreach($queryalternatifkriteria as $dataalkr){
					$alternatifkriteria[$i][$j] = $dataalkr->nilai;
					}
					
					$j++;
			}
  			$i++;
		}
			
		$pembagi = array();
		
		for ($i=0;$i<count($kriteria);$i++)
		{
			$pembagi[$i] = 0;
			for ($j=0;$j<count($alternatif);$j++)
			{
				$pembagi[$i] = $pembagi[$i] + ($alternatifkriteria[$j][$i] * $alternatifkriteria[$j][$i]);
			}
			$pembagi[$i] = sqrt($pembagi[$i]);
		}

	


		
		$normalisasi = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			for ($j=0;$j<count($kriteria);$j++)
			{
				$normalisasi[$i][$j] = $alternatifkriteria[$i][$j] / $pembagi[$j];
			}
		}

		$terbobot = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			for ($j=0;$j<count($kriteria);$j++)
			{
				$terbobot[$i][$j] = $normalisasi[$i][$j] * $kepentingan[$j];
			}
		}	
		
		$aplus = array();
		
		for ($i=0;$i<count($kriteria);$i++)
		{
			if ($costbenefit[$i] == 'Cost')
			{
				for ($j=0;$j<count($alternatif);$j++)
				{
					if ($j == 0) 
					{ 
						$aplus[$i] = $terbobot[$j][$i];
					}
					else 
					{
						if ($aplus[$i] > $terbobot[$j][$i])
						{
							$aplus[$i] = $terbobot[$j][$i];
						}
					}
				}
			}
			else 
			{
				for ($j=0;$j<count($alternatif);$j++)
				{
					if ($j == 0) 
					{ 
						$aplus[$i] = $terbobot[$j][$i];
					}
					else 
					{
						if ($aplus[$i] < $terbobot[$j][$i])
						{
							$aplus[$i] = $terbobot[$j][$i];
						}
					}
				}
			}
		}
		
		$amin = array();
		
		for ($i=0;$i<count($kriteria);$i++)
		{
			if ($costbenefit[$i] == 'Cost')
			{
				for ($j=0;$j<count($alternatif);$j++)
				{
					if ($j == 0) 
					{ 
						$amin[$i] = $terbobot[$j][$i];
					}
					else 
					{
						if ($amin[$i] < $terbobot[$j][$i])
						{
							$amin[$i] = $terbobot[$j][$i];
						}
					}
				}
			}
			else 
			{
				for ($j=0;$j<count($alternatif);$j++)
				{
					if ($j == 0) 
					{ 
						$amin[$i] = $terbobot[$j][$i];
					}
					else 
					{
						if ($amin[$i] > $terbobot[$j][$i])
						{
							$amin[$i] = $terbobot[$j][$i];
						}
					}
				}
			}
		}
		
		$dplus = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			$dplus[$i] = 0;
			for ($j=0;$j<count($kriteria);$j++)
			{
				$dplus[$i] = $dplus[$i] + (($aplus[$j] - $terbobot[$i][$j]) * ($aplus[$j] - $terbobot[$i][$j]));
			}
			$dplus[$i] = sqrt($dplus[$i]);
		}
		
		$dmin = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			$dmin[$i] = 0;
			for ($j=0;$j<count($kriteria);$j++)
			{
				$dmin[$i] = $dmin[$i] + (($terbobot[$i][$j] - $amin[$j]) * ($terbobot[$i][$j] - $amin[$j]));
			}
			$dmin[$i] = sqrt($dmin[$i]);
		}
		
		
		$hasil = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			$hasil[$i] = $dmin[$i] / ($dmin[$i] + $dplus[$i]);
		}	
		
		$alternatifrangking = array();
		$hasilrangking = array();
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			$hasilrangking[$i] = $hasil[$i];
			$alternatifrangking[$i] = $alternatif[$i];
		}
		
		for ($i=0;$i<count($alternatif);$i++)
		{
			for ($j=$i;$j<count($alternatif);$j++)
			{
				if ($hasilrangking[$j] > $hasilrangking[$i])
				{
					$tmphasil = $hasilrangking[$i];
					$tmpalternatif = $alternatifrangking[$i];
					$hasilrangking[$i] = $hasilrangking[$j];
					$alternatifrangking[$i] = $alternatifrangking[$j];
					$hasilrangking[$j] = $tmphasil;
					$alternatifrangking[$j] = $tmpalternatif;
				}
			}
		}

		$topsis_result = DB::table('topsis_result')
           ->select('topsis_result.*')
           ->where(DB::raw("DATE_FORMAT(created_at, '%m')"), '=', $month)
           ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year)
           ->first();

		if($topsis_result){
			return view('backend.topsis.result', ['hasilrangking'=>$hasilrangking[0], 'alternatifrangking'=>$alternatifrangking[0], 'hasilrangkingsemua'=>$hasilrangking, 'alternatifrangkingsemua'=>$alternatifrangking, 'alternatif'=>$alternatif, 'kriteria'=>$kriteria, 'costbenefit'=>$costbenefit, 'kepentingan'=>$kepentingan, 'alternatifkriteria'=>$alternatifkriteria, 'pembagi'=>$pembagi, 'normalisasi'=>$normalisasi, 'terbobot'=>$terbobot, 'aplus'=>$aplus, 'amin'=>$amin, 'dplus'=>$dplus, 'dmin'=>$dmin, 'hasil'=>$hasil]);
		}
		
		else{
		for($i=0;$i<count($hasilrangking);$i++){

			$data = [
                'employee_name' => $alternatifrangking[$i],
                'value' => $hasilrangking[$i]
                ];

          	$topsis =  new TopsisResult();
      		$topsis->employee_name = $data['employee_name'];
      		$topsis->value = $data['value'];
      		$topsis->month = $month;
      		$topsis->year = $year;
      		$topsis->save();
         }

         return view('backend.topsis.result', ['hasilrangking'=>$hasilrangking[0], 'alternatifrangking'=>$alternatifrangking[0], 'hasilrangkingsemua'=>$hasilrangking, 'alternatifrangkingsemua'=>$alternatifrangking, 'alternatif'=>$alternatif, 'kriteria'=>$kriteria, 'costbenefit'=>$costbenefit, 'kepentingan'=>$kepentingan, 'alternatifkriteria'=>$alternatifkriteria, 'pembagi'=>$pembagi, 'normalisasi'=>$normalisasi, 'terbobot'=>$terbobot, 'aplus'=>$aplus, 'amin'=>$amin, 'dplus'=>$dplus, 'dmin'=>$dmin, 'hasil'=>$hasil]);
		}
        
    }

    public function store(Request $request)
    {   
      $month =  $request->month;
      $year =  date('Y');

      $employee =  Employee::all()->toArray();

     //  $historyalternative = AlternativeKriteria::where(DB::raw("DATE_FORMAT(created_at, '%m')"), '=', $month)
     //        	->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year);


    	// if($historyalternative){
    	// 	session()->flash('message', 'Karyawan telah dibuat kriterianya bulan ini.');

     //    	return redirect()->back();
    	// }

    	// else{
      $kerajinan = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_kerajinan'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%m')"), '=', $month)
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->get();

       $kedisiplinan = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_kedisplinan'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%m')"), '=', $month)
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->where('presences.additional', '=', 'Terlambat')
            ->get();

        $lembur = DB::table('presences')
            ->select('presences.employee_id', DB::raw('count(presences.id) as total_lembur'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%m')"), '=', $month)
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->where('presences.overtime_status', '=', 'Lembur')
            ->get();

        $masa_kerja = DB::table('employees')
            ->select('employees.id', (DB::raw('DATEDIFF(current_date(), DATE_FORMAT(employees.created_at, "%Y-%m-%d")) as in_date')))
            ->get();


      // dd($masa_kerja);

      foreach($kedisiplinan as $item){

                $altkri =  new AlternativeKriteria();
                $altkri->id_alternatif = $item->employee_id;
                $altkri->id_kriteria = 1;
                $altkri->nilai = $item->total_kedisplinan;
                $altkri->save();
      }

      foreach($kerajinan as $item){

      			if ($item->total_kerajinan > 5) {
      				$nilai = 70;
      			}
      			if ($item->total_kerajinan <= 5 && $item->total_kerajinan > 3) {
      				$nilai = 50;
      			}
      			if ($item->total_kerajinan <= 3 && $item->total_kerajinan > 1) {
      				$nilai = 40;
      			}
      			if ($item->total_kerajinan <= 1) {
      				$nilai = 20;
      			}

                $altkri =  new AlternativeKriteria();
                $altkri->id_alternatif = $item->employee_id;
                $altkri->id_kriteria = 3;
                $altkri->nilai = $nilai;
                $altkri->save();
      }

      foreach($lembur as $item){

      			if ($item->total_lembur >= 5) {
      				$nilai = 70;
      			}
      			if ($item->total_lembur <= 3 && $item->total_lembur > 1) {
      				$nilai = 50;
      			}
      			if ($item->total_lembur <= 1) {
      				$nilai = 20;
      			}
      			if ($item->total_lembur == NULL) {
      				$nilai = 0;
      			}

                $altkri =  new AlternativeKriteria();
                $altkri->id_alternatif = $item->employee_id;
                $altkri->id_kriteria = 2;
                $altkri->nilai = $nilai;
                $altkri->save();
      }

      foreach($masa_kerja as $item){

      			if ($item->in_date >= 365) {
      				$nilai = 70;
      			}
      			if ($item->in_date < 365 && $item->in_date > 100) {
      				$nilai = 50;
      			}
      			if ($item->in_date <= 100) {
      				$nilai = 20;
      			}
      			if ($item->in_date == NULL) {
      				$nilai = 0;
      			}

                $altkri =  new AlternativeKriteria();
                $altkri->id_alternatif = $item->id;
                $altkri->id_kriteria = 4;
                $altkri->nilai = $nilai;
                $altkri->save();
      }

      session()->flash('message', 'Anda berhasil menambahkan data alternatif kriteria.');

     return redirect('/admin/result');
     // }
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        $tanggung_jawab = Kriteria::where('id_kriteria', 7)->first();
        $skill = Kriteria::where('id_kriteria', 5)->first();
        $kejujuran = Kriteria::where('id_kriteria', 6)->first();
        $kerjasama = Kriteria::where('id_kriteria', 8)->first();
        // $employee = Employee::where('id_card',$request->id_card)->first();

    
        return view('backend.topsis.edit', ['employee'=>$employee, 'tanggung_jawab'=>$tanggung_jawab, 'skill'=>$skill, 'kejujuran'=>$kejujuran, 'kerjasama'=>$kerjasama]);
    }
    
    public function update(Request $request, $id)
    {
    	$month =  date('m');
      	$year =  date('Y');
    	$history_tanggungjawab = AlternativeKriteria::where('id_alternatif', $id)
    			->where(DB::raw("DATE_FORMAT(created_at, '%m')"), '=', $month)
            	->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), '=', $year)
            	->first();

    	if($history_tanggungjawab){
    		session()->flash('message', 'Karyawan telah dibuat kriterianya bulan ini.');

        	return redirect()->back();
    	}
    	else{
        $alternatifkriteria = new AlternativeKriteria;
        $tanggung_jawab = $request->tanggung_jawab;
        $id_kriteria_tanggung_jawab = $request->id_kriteria_tanggung_jawab;
        $alternatifkriteria->id_alternatif = $id;
        $alternatifkriteria->id_kriteria = $id_kriteria_tanggung_jawab;
        $alternatifkriteria->nilai = $tanggung_jawab;
        $alternatifkriteria->save();

        $alternatifkriteria = new AlternativeKriteria;
        $skill = $request->skill;
        $id_kriteria_skill = $request->id_kriteria_skill;
        $alternatifkriteria->id_alternatif = $id;
        $alternatifkriteria->id_kriteria = $id_kriteria_skill;
        $alternatifkriteria->nilai = $skill;
        $alternatifkriteria->save();

        $alternatifkriteria = new AlternativeKriteria;
        $kejujuran = $request->kejujuran;
        $id_kriteria_kejujuran = $request->id_kriteria_kejujuran;
        $alternatifkriteria->id_alternatif = $id;
        $alternatifkriteria->id_kriteria = $id_kriteria_kejujuran;
        $alternatifkriteria->nilai = $kejujuran;
        $alternatifkriteria->save();

        $alternatifkriteria = new AlternativeKriteria;
        $kerjasama = $request->kerjasama;
        $id_kriteria_kerjasama = $request->id_kriteria_kerjasama;
        $alternatifkriteria->id_alternatif = $id;
        $alternatifkriteria->id_kriteria = $id_kriteria_kerjasama;
        $alternatifkriteria->nilai = $kerjasama;
        $alternatifkriteria->save();

        session()->flash('message', 'Data Kriteria berhasil ditambah.');

        return redirect('/admin/topsis');
        }
    }

    // public function storeTopsis(Request $request)
    // {
    // 	$alternatif = $request->alternatif;
    // 	$nilai = $request->alternatif;

    //     $employee = Employee::find($id);
    //     $tanggung_jawab = Kriteria::where('id_kriteria', 7)->first();
    //     $skill = Kriteria::where('id_kriteria', 5)->first();
    //     $kejujuran = Kriteria::where('id_kriteria', 6)->first();
    //     $kerjasama = Kriteria::where('id_kriteria', 8)->first();
    //     // $employee = Employee::where('id_card',$request->id_card)->first();

    
    //     return view('backend.topsis.edit', ['employee'=>$employee, 'tanggung_jawab'=>$tanggung_jawab, 'skill'=>$skill, 'kejujuran'=>$kejujuran, 'kerjasama'=>$kerjasama]);
    // }

    public function getList()
    {
        $topsis = DB::table('topsis_result')
            // ->join('employees', 'employees.name', '=', 'topsis_result.employee_name')
            ->select('topsis_result.*')
            ->groupby('year')
            ->get();
        
        // $orders = DB::table('orders')
        // ->where('orders.id', $id)
        // ->select('orders.*')
        // ->first();

        // $order_detail = DB::table('order_detail')
        // ->where('order_detail.order_id', $id)
        // ->join('menus', 'menus.id', '=','order_detail.menu_id')
        // ->select('order_detail.*', 'menus.name as menu_name', 'menus.price as menu_price')
        // ->get();
            // ->whereMonth('presences.date', '=', $dt->month);
        return view('backend.topsis.history', ['topsis'=>$topsis]);
    }


    public function printHistoryTopsis($history)
    {
  //      $topsis_result = TopsisResult::select('*')
		// ->groupBy('month', 'year')
		// ->where(DB::raw('max(value) as max_value'))
		// ->get();
		$year =  date('Y');
		// $topsis_month = DB::table('topsis_result')
		// 	->where('year', $year)
		// 	->groupBy('month')
		// 	->pluck('month');

		$topsis_result = DB::table('topsis_result')
		->select('employee_name', DB::raw('max(topsis_result.value) as max_value'), 'month', 'year')
		->groupBy('month','year')
		// ->where('value', DB::raw('(select max(value) from topsis_result)'))
		->where('year', $history)
		->get();

		$total_transaction = DB::table('topsis_result')
        ->select('topsis_result.*')
        //->where(DB::raw("DATE_FORMAT(topsis_result.created_at, '%m-%Y')"), '=', $history)
        ->where('year', $history)
        ->first();

        $dt = Carbon::now();
        $date = $dt->toDateString();
      
      	//$month = Month::find($total_transaction->month);

		//dd($total_transaction);

        $pdf = PDF::loadView('backend/pdf/topsis', ['topsis_result' => $topsis_result, 'total_transaction' => $total_transaction, 'date' => $date]);
        return $pdf->stream('Topsis'.$total_transaction->year.'.pdf');
    }

    public function searchTopsis(Request $request)
    {
        // $month = $request->month;
        $year = $request->years;

        $topsis = TopsisResult::select('topsis_result.*')
            ->where('year', $year)
            ->groupBy('year')
            ->get();
   
        if ($topsis){
          session()->flash('topsis_found', true);
        }
        else{
          session()->flash('topsis_not_found', true);
        }
        
        return view('backend.topsis.history', ['topsis'=>$topsis]);  
    }
}