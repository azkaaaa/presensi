<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Alternative;
use App\AlternativeKriteria;
use App\Kriteria;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TopsisController extends Controller
{
    public function index()
    {
    	$kriteria = Kriteria::all();
    	$alternative = Alternative::all();
        return view('backend.topsis.index', ['kriteria'=>$kriteria, 'alternative'=>$alternative]);
    }

    public function create()
    {	
    	$alternatif = array(); //array("Galaxy", "iPhone", "BB", "Lumia");
	
		$dataalternatif = Alternative::all();
		$i=0;
		foreach ($dataalternatif as $row) {
  			$alternatif[$i] = $row->nama_alternatif;
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
		
		$dataalternatif = Alternative::all();
		$i=0;
		foreach ($dataalternatif as $dataal) {
			$datakriteria = Kriteria::all();
			$j=0;
			foreach ($datakriteria as $datakr) {
				$queryalternatifkriteria = AlternativeKriteria::where('id_alternatif', $dataal->id_alternatif)->where('id_kriteria', $datakr->id_kriteria)->get();

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
}
