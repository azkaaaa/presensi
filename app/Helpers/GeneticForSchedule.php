<?php
namespace App\Helpers;
use App\Schedule;
use App\Employee;
use App\Shift;
use App\Week;
use App\Day;
class GeneticForSchedule {
    //
    private $month;
    private $populasi;
    private $crossOver;
    private $mutasi;
    private $employee = array();
    private $shift = array();
    private $day = array();
    private $count = array();
    private $logAmbilData;
    private $logInisialisasi;
    
    private $log;
    private $induk = array();
    private $individu = array(array(array()));
    public function __construct($month,$populasi,$crossOver,$mutasi){
      $this->month          = $month;
      $this->populasi       = intval($populasi);
      $this->crossOver      = $crossOver;
      $this->mutasi         = $mutasi;
    }
    public function AmbilData()
    {
         //Fill Array of Employee Variables
        $rs_employee = Employee::all()->except(3);
        $i = 0;
        foreach ($rs_employee as $data) {
            $this->employee[$i]    = intval($data->id);
            $i++;
        }

        $rs_shift = Shift::all();
        $i = 0;
        foreach ($rs_shift as $data) {
            $this->shift[$i]    = intval($data->id);
            $i++;
        }
        $rs_day = Day::all();
        $i = 0;
        foreach ($rs_day as $data) {
            $this->day[$i]    = intval($data->id);
            $i++; 
    	}

         // dd($this->populasi);     


        // $all_employee = count($this->employee);        
        // $all_shift = count($this->shift);
        // $all_day = count($this->day);

        // $all_count = $all_employee*$all_day;

        // for($i = 0; $i < $all_count; $i++) {
        //     $this->count[$i] = $i;
        // }
    }
    
    
    public function Inisialisai()
    {    
        $all_employee = count($this->employee);        
        $all_shift = count($this->shift);
        $all_day = count($this->day);


        //$all_count = $all_employee*$all_day;
        // $jumlah_ruang_reguler = count($this->ruangReguler);
        // $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            
            for ($j = 0; $j < $all_employee; $j++) {
                
                // $sks = $this->sks[$j];
                
                $this->individu[$i][$j][0] = $j;
                
                // Penentuan shift secara acak 
                $this->individu[$i][$j][1] = mt_rand(0,  $all_day - 1);
                
                // Penentuan hari secara acak 
                $this->individu[$i][$j][2] = mt_rand(0, $all_day - 1);

                // Penentuan hari secara acak 
                $this->individu[$i][$j][3] = mt_rand(0, $all_day - 1);

                // Penentuan hari secara acak 
                $this->individu[$i][$j][4] = mt_rand(0, $all_day - 1);

                // Penentuan shift secara acak 
                $this->individu[$i][$j][5] = mt_rand(0, $all_shift - 1);

                // Penentuan hari secara acak 
                // $this->individu[$i][$j][5] = mt_rand(0, $all_employee - 1);
           
            }
        }
        // dd($this->individu);
    }
    
    private function CekFitness($indv)
    {
        $penalty = 0;
        
        $all_employee = count($this->employee);        
        $all_shift = count($this->shift);
        $all_day = count($this->day);

        // dd($all_employee);

        //$all_count = $all_employee*$all_day;
        
        for ($i = 0; $i < $all_employee; $i++)
        {
          
          // $sks = intval($this->sks[$i]);
          $employee_a = intval($this->employee[$i]);        
          $day_one_a = intval($this->individu[$indv][$i][1]);
          $day_two_a = intval($this->individu[$indv][$i][2]);
          $day_three_a = intval($this->individu[$indv][$i][3]);
          $day_four_a = intval($this->individu[$indv][$i][4]);          
          $shift_a = intval($this->individu[$indv][$i][5]);          

            for ($j = 0; $j < $all_employee; $j++) {                 
              	
                $employee_b = intval($this->employee[$j]);
                $day_one_b = intval($this->individu[$indv][$j][1]);
                $day_two_b = intval($this->individu[$indv][$j][2]);
                $day_three_b = intval($this->individu[$indv][$j][3]);
                $day_four_b = intval($this->individu[$indv][$j][4]);
                $shift_b = intval($this->individu[$indv][$j][5]);
                  
                  
                //1.bentrok ruang dan waktu dan 3.bentrok dosen
                
                //ketika pemasaran matakuliah sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;
                
                //#region Bentrok Ruang dan Waktu
                //Ketika jam,hari dan ruangnya sama, maka penalty + satu
                if ($day_one_a == $day_one_b &&
                    $day_two_a == $day_two_b &&
                    $day_three_a == $day_three_b &&
                    $day_four_a == $day_four_b)
                {
                    $penalty += 1;
                }

                if ($day_one_a == $day_one_b &&
                    $shift_a == $shift_b)
                {
                    $penalty += 1;
                }

                if ($day_two_a == $day_two_b &&
                    $shift_a == $shift_b)
                {
                    $penalty += 1;
                }

                if ($day_three_a == $day_three_b &&
                    $shift_a == $shift_b)
                {
                    $penalty += 1;
                }

                if ($day_four_a == $day_four_b &&
                    $shift_a == $shift_b)
                {
                    $penalty += 1;
                }
                
                //______________________BENTROK DOSEN
                // if (
                // //ketika jam sama
                //     $shift_a == $shift_b && 
                // //dan hari sama
                //     $employee_a == $employee_b && 
                // //dan dosennya sama
                //     $day_a == $day_b)
                // {
                //   //maka...
                //   $penalty += 1;
                // }               
                             
            }                  
            
        }      
        
        $fitness = floatval(1 / (1 + $penalty)); 
           // dd($fitness);     
        
        return $fitness;
         
    }
    
    public function HitungFitness()
    {
        //hard constraint
        //1.bentrok ruang dan waktu
        //2.bentrok sholat jumat
        //3.bentrok dosen
        //4.bentrok keinginan waktu dosen 
        //5.bentrok waktu dhuhur 
        //=>6.praktikum harus pada ruang lab {telah ditetapkan dari awal perandoman
        //    bahwa jika praktikum harus ada pada LAB dan mata kuliah reguler harus 
        //    pada kelas reguler
        
        
        //soft constraint //TODO
        $fitness = array();
        
        for ($indv = 0; $indv < $this->populasi; $indv++)
        {            
            $fitness[$indv] = $this->CekFitness($indv);            
        }
        
        return $fitness;

    }
    
    #endregion
    
    #region Seleksi
    public function Seleksi($fitness)
    {
        $jumlah = 0;
        $rank   = array();
        
        
        for ($i = 0; $i < $this->populasi; $i++)
        {
          //proses ranking berdasarkan nilai fitness
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++)
            {
              //ketika nilai fitness jadwal sekarang lebih dari nilai fitness jadwal yang lain,
              //ranking + 1;
              //if (i == j) continue;
                
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);
                
                if ( $fitnessA > $fitnessB)
                {
                    $rank[$i] += 1;                    
                }
            }
            
            $jumlah += $rank[$i];
        }
        
        $jumlah_rank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++)
        {
            //proses seleksi berdasarkan ranking yang telah dibuat
            //int nexRandom = random.Next(1, jumlah);
            //random = new Random(nexRandom);
            $target = mt_rand(0, $jumlah - 1);           
          
            $cek    = 0;
            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }
    //#endregion
    
    public function StartCrossOver()
    {
        $individu_baru = array(array(array()));
        $all_employee = count($this->employee);        
        $all_shift = count($this->shift);
        $all_day = count($this->day);

        //$all_count = $all_employee*$all_day;
        
        for ($i = 0; $i < $this->populasi; $i += 2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            
            //Two point crossover
            if (floatval($cr) < floatval($this->crossOver)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, $all_employee - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $all_employee - 1);
                }
                
                
                //var_dump($this->induk);
                
                
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 3; $k++) {                        
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                
                //Penentuan jadwal baru dai titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }
                
                //penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < $all_employee; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $all_employee; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $all_employee = count($this->employee);        
        $all_shift = count($this->shift);
        $all_day = count($this->day);

        //$all_count = $all_employee*$all_day;
        
        for ($i = 0; $i < $this->populasi; $i += 2) {
          for ($j = 0; $j < $all_employee ; $j++) {
            for ($k = 0; $k < 3; $k++) {
                $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
            }
          }
        }
    }
    
    public function Mutasi()
    {
        $fitness = array();
        //proses perandoman atau penggantian komponen untuk tiap jadwal baru
        $r       = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        
        $all_employee = count($this->employee);        
        $all_shift = count($this->shift);
        $all_day = count($this->day);

        //$all_count = $all_employee*$all_day;
        // $jumlah_jam = count($this->jam);
        // $jumlah_hari = count($this->hari);
        // $jumlah_ruang_reguler = count($this->ruangReguler);
        // $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            //Ketika nilai random kurang dari nilai probalitas Mutasi, 
            //maka terjadi penggantian komponen
            
            if ($r < $this->mutasi) {
                //Penentuan pada matakuliah dan kelas yang mana yang akan dirandomkan atau diganti
                $krom = mt_rand(0, $all_employee - 1);
                
                // $j = intval($this->sks[$krom]);
                $this->individu[$i][$krom][1] = mt_rand(0, $all_day - 1);
                //Proses penggantian hari
                $this->individu[$i][$krom][2] = mt_rand(0, $all_day - 1);

                $this->individu[$i][$krom][3] = mt_rand(0, $all_day - 1);

                $this->individu[$i][$krom][4] = mt_rand(0, $all_day - 1);

                $this->individu[$i][$krom][5] = mt_rand(0, $all_shift - 1);
                
                //proses penggantian ruang               
                
                // if ($this->jenis_mk[$krom] === $this->TEORI) {
                //     $this->individu[$i][$krom][3] = $this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)];
                // } else {
                //     $this->individu[$i][$krom][3] = $this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)];
                // }
                
                
            }
            
            $fitness[$i] = $this->CekFitness($i);
        }
        return $fitness;
    }
    
    
    public function GetIndividu($indv)
    {
        //return individu;
        
        //int[,] individu_solusi = new int[mata_kuliah.Length, 4];
        $individu_solusi = array(array());
        
        for ($j = 0; $j < count($this->employee); $j++)
        {
            $individu_solusi[$j][0] = intval($this->employee[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][1] = intval($this->day[$this->individu[$indv][$j][1]]);
            $individu_solusi[$j][2] = intval($this->day[$this->individu[$indv][$j][2]]);       
            $individu_solusi[$j][3] = intval($this->day[$this->individu[$indv][$j][3]]);       
            $individu_solusi[$j][4] = intval($this->day[$this->individu[$indv][$j][4]]);       
            $individu_solusi[$j][5] = intval($this->shift[$this->individu[$indv][$j][5]]);       
        }
        // dd($individu_solusi);
        
        return $individu_solusi;
    }
    
    
}