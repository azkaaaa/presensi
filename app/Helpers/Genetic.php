<?php
namespace App\Helpers;
use App\Schedule;
use App\Employee;
use App\Shift;
use App\Week;
use App\Day;
use App\OvertimeDay;
class Genetic {
    //
    private $month;
    private $schedule_week;
    private $populasi;
    private $crossOver;
    private $mutasi;
    private $employee = array();
    private $shift = array();
    private $day = array();
    private $week = array();
    private $off_day = array();
    private $sum_days = array();
    private $ord_employee = array();
    private $overtime_day = array();
    private $ord_overtime_day = array();
    private $logAmbilData;
    private $logInisialisasi;
    
    private $log;
    private $induk = array();
    private $individu = array(array(array()));
    public function __construct($month,$schedule_week,$populasi,$crossOver,$mutasi){
      $this->schedule_week  = $schedule_week;
      $this->month          = $month;
      $this->populasi       = intval($populasi);
      $this->crossOver      = $crossOver;
      $this->mutasi         = $mutasi;
    }
    public function AmbilData()
    {
        $emp_times= Employee::count();
        $week_times= 2;
        $shift_times= ($week_times * Employee::count())/2;
        $rs_employee = Employee::all();
        for($x=0; $week_times>$x; $x++){
        foreach ($rs_employee as $data) {
            array_unshift($this->employee,"");
            unset($this->employee[0]);
            $this->employee[]    = intval($data->id);
            }
        }

        $emp_numbers = $this->employee;
        asort($emp_numbers);
        
        foreach($emp_numbers as $x => $x_value) {
        $this->ord_employee[]    = $x_value;
        }

        $rs_shift = Shift::all();
        for($x=0; $shift_times>$x; $x++){
        foreach ($rs_shift as $data) {
            $this->shift[]    = intval($data->id);
            }
        }

        if($this->schedule_week == 'week_12'){
            $emp_shift = $this->shift;
            asort($emp_shift);
            $rs_week = Week::orderBy('id','asc')->take(2)->get();

        }
        else{
            $emp_shift = $this->shift;
            rsort($emp_shift);
            $rs_week = Week::orderBy('id','desc')->take(2)->get();

        }

        foreach($emp_shift as $y => $y_value) {
        $this->ord_shift[]    = $y_value;
        }

        for($x=0; $emp_times>$x; $x++){
        foreach ($rs_week as $data) {
            $this->day[]    = intval($data->id);
            }
        }

        $rs_day = Day::all();
        for($x=0; $emp_times>$x; $x++){
        foreach ($rs_day as $data) {
            $this->sum_days[]    = intval($data->id);
            }
        }

        $rs_overtime_day = OvertimeDay::all();
        for($x=0; $emp_times>$x; $x++){
        foreach ($rs_overtime_day as $data) {
            $this->ord_overtime_day[]    = intval($data->id);
            }
        }
    
        $i = 0;
        foreach ($rs_week as $data) {
            $this->week[]    = intval($data->id);
            $i++;
            }
        
        // $days_name = ['1','2','3','4','5'];
        // foreach($days_name as $y => $y_value) {
        // $this->sum_days[]    = $y_value;
        // }
        // dd($this->sum_days);
    }
    
    
    public function Inisialisai()
    {        
        $all_employee = $this->ord_employee;        
        $all_shift = $this->ord_shift;
        $all_day = count($this->day);
        $all_test = count($this->shift);
        $all_sum_days = count($this->sum_days);
        $all_ord_overtime_days = count($this->ord_overtime_day);
        //dd($this->sum_days);
        // $jumlah_ruang_reguler = count($this->ruangReguler);
        // $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            
            for ($j = 0; $j < $all_day; $j++) {
                
                // Penentuan minggu secara berurut              
                $this->individu[$i][$j][0] = $j;
                
                // Penentuan shift secara acak 
                $this->individu[$i][$j][1] = mt_rand(0,  $all_test - 1);
                
                // Penentuan karyawan secara urut 
                $this->individu[$i][$j][2] = $all_employee[$j];

                // Penentuan libur secara acak
                $this->individu[$i][$j][3] = mt_rand(0,  $all_sum_days - 1);

                // Penentuan shift secara urut 
                $this->individu[$i][$j][4] = $all_shift[$j];

                // Penentuan lembur secara acak 
                $this->individu[$i][$j][5] = mt_rand(0,  $all_ord_overtime_days - 1);

                
                
            }
        }
        // dd($this->day);
    }
    
    private function CekFitness($indv)
    {
        $penalty = 0;
        
        $all_week = count($this->week);
        $all_day = count($this->day);
        //dd($all_week);
        
        for ($i = 1; $i < $all_day; $i++)
        {
          // $sks = intval($this->sks[$i]);
          $week_a = intval($this->day[$i]);        
          $shift_a = intval($this->individu[$indv][$i][1]);
          $employee_a = intval($this->individu[$indv][$i][2]);
          $off_a = intval($this->individu[$indv][$i][3]);
          $shift_true_a = intval($this->individu[$indv][$i][4]);
          $overtime_day_a = intval($this->individu[$indv][$i][5]);
          
            for ($j = 1; $j < $all_day; $j++) {                 
                
                $week_b = intval($this->day[$j]);
                $shift_b = intval($this->individu[$indv][$j][1]);
                $employee_b = intval($this->individu[$indv][$j][2]);
                $off_b = intval($this->individu[$indv][$j][3]);
                $shift_true_b = intval($this->individu[$indv][$j][4]);
                $overtime_day_b = intval($this->individu[$indv][$j][5]);

                 //dd($all_week);
                
                //ketika pemasaran matakuliah sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;
                //Ketika libur dan minggunya sama, maka penalty + satu
                if (//ketika shift sama
                    $overtime_day_a == $overtime_day_b &&
                    //ketika libur sama
                    $off_a == $off_b)
                    {
                        $penalty += 1;
                    }

                // if ($off_a == $overtime_day_a OR $off_b == $overtime_day_b)
                // {
                //         $penalty += 1;
                // }      

                // if ($shift_a == $shift_true_a OR $shift_b == $shift_true_b OR $shift_a == $shift_true_b OR $shift_b == $shift_true_a)
                // {
                //     if (//ketika shift sama
                //     $week_a == $week_b &&
                //     //ketika shift sama
                //     $shift_true_a == $shift_true_b &&
                //     //ketika libur sama
                //     $off_a == $off_b)
                //     {
                //         $penalty += 1;
                //     }
                // }            
            }                  
            
        }      
        
        $fitness = floatval(1 / (1 + $penalty)); 
        
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
        //$fitness = array();
        
        for ($indv = 0; $indv < $this->populasi; $indv++)
        {            
            $fitness[$indv] = $this->CekFitness($indv);            
        }
    
         //dd($fitness);
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
        $all_day = count($this->day);
        
        for ($i = 0; $i < $this->populasi; $i += 2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            
            //Two point crossover
            if (floatval($cr) < floatval($this->crossOver)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, $all_day - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $all_day - 1);
                }
                
                
                //var_dump($this->induk);
                
                
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 6; $k++) {                        
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                
                //Penentuan jadwal baru dari titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 6; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }
                
                //penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < $all_day; $j++) {
                    for ($k = 0; $k < 6; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $all_day; $j++) {
                    for ($k = 0; $k < 6; $k++) {
                        $individu_baru[$i][$j][$k]     = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $all_day = count($this->day);
        
        for ($i = 0; $i < $this->populasi; $i += 2) {
          for ($j = 0; $j < $all_day ; $j++) {
            for ($k = 0; $k < 6; $k++) {
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
        $all_day = count($this->day);
        $all_sum_days = count($this->sum_days);
        $all_employee = $this->ord_employee;        
        $all_shift = $this->ord_shift;
        $all_test = count($this->shift);
        $all_ord_overtime_days = count($this->ord_overtime_day);
        // $jumlah_jam = count($this->jam);
        // $jumlah_hari = count($this->hari);
        // $jumlah_ruang_reguler = count($this->ruangReguler);
        // $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            //Ketika nilai random kurang dari nilai probalitas Mutasi, 
            //maka terjadi penggantian komponen
            
            if ($r < $this->mutasi) {
                //Penentuan pada matakuliah dan kelas yang mana yang akan dirandomkan atau diganti
                $krom = mt_rand(0, $all_day - 1);
                
                // $j = intval($this->sks[$krom]);
                $this->individu[$i][$krom][1] = mt_rand(0,  $all_test - 1);
                //Proses penggantian karyawan
                //$this->individu[$i][$krom][2] = $all_employee;
                 //Proses penggantian hari libur
                $this->individu[$i][$krom][3] = mt_rand(0,  $all_sum_days - 1);    
                $this->individu[$i][$krom][5] = mt_rand(0,  $all_ord_overtime_days - 1);    
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
        
        for ($j = 0; $j < count($this->day); $j++)
        {
            $individu_solusi[$j][0] = intval($this->day[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][2] = intval($this->employee[$this->individu[$indv][$j][2]]);       
            $individu_solusi[$j][3] = intval($this->sum_days[$this->individu[$indv][$j][3]]); 
            $individu_solusi[$j][4] = intval($this->shift[$this->individu[$indv][$j][4]]);
            $individu_solusi[$j][5] = intval($this->ord_overtime_day[$this->individu[$indv][$j][5]]);

        }
        // dd($individu_solusi);
        
        return $individu_solusi;
    }
    
    
}