<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Employee;
use App\Alternative;
use App\AlternativeKriteria;
use App\Kriteria;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class TopsisController extends Controller
{
    public function index()
    {
    	$kriteria = Kriteria::all();
    	$alternative = Alternative::all();
        return view('backend.topsis.index', ['kriteria'=>$kriteria, 'alternative'=>$alternative]);
    }

    public function show()
    {
        return view('backend.topsis.create');
    }

    public function create()
    {	
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
		
		$dataalternatif = Employee::all();
		$i=0;
		foreach ($dataalternatif as $dataal) {
			$datakriteria = Kriteria::all();
			$j=0;
			foreach ($datakriteria as $datakr) {
				$queryalternatifkriteria = AlternativeKriteria::where('id_alternatif', $dataal->id)->where('id_kriteria', $datakr->id_kriteria)->get();

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

        return view('backend.topsis.result', ['hasilrangking'=>$hasilrangking[0], 'alternatifrangking'=>$alternatifrangking[0], 'hasilrangkingsemua'=>$hasilrangking, 'alternatifrangkingsemua'=>$alternatifrangking, 'alternatif'=>$alternatif, 'kriteria'=>$kriteria, 'costbenefit'=>$costbenefit, 'kepentingan'=>$kepentingan, 'alternatifkriteria'=>$alternatifkriteria, 'pembagi'=>$pembagi, 'normalisasi'=>$normalisasi, 'terbobot'=>$terbobot, 'aplus'=>$aplus, 'amin'=>$amin, 'dplus'=>$dplus, 'dmin'=>$dmin, 'hasil'=>$hasil]);
    }

    public function store(Request $request)
    {   
      $year =  $request->year;
      $employee =  Employee::all()->toArray();

      $kerajinan = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_kerajinan'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->get();

       $kedisiplinan = DB::table('presences')
            ->select('employee_id', DB::raw('count(presences.id) as total_kedisplinan'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->where('presences.additional', '=', 'Terlambat')
            ->get();

        $lembur = DB::table('presences')
            ->select('presences.employee_id', DB::raw('count(presences.id) as total_lembur'))
            ->groupby('employee_id')
            ->where(DB::raw("DATE_FORMAT(presences.date, '%Y')"), '=', $year)
            ->where('presences.overtime_status', '=', 'Lembur')
            ->get();

      // dd($lembur);

      foreach($kedisiplinan as $item){

                $altkri =  new AlternativeKriteria();
                $altkri->id_alternatif = $item->employee_id;
                $altkri->id_kriteria = 1;
                $altkri->nilai = $item->total_kedisplinan;
                $altkri->save();
      }

      foreach($kerajinan as $item){

      			if ($item->total_kerajinan >= 5) {
      				$nilai = 70;
      			}
      			if ($item->total_kerajinan <= 3 && $item->total_kerajinan > 1) {
      				$nilai = 50;
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

      session()->flash('message', 'Anda berhasil menambahkan data alternatif kriteria.');

     return redirect('/admin/topsis');
    }
}
