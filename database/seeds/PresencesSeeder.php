<?php

use Illuminate\Database\Seeder;

class PresencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presences')->insert([
          [
            'id'=> 1,
            'employee_id'=>1,
            'time_in'=>'07:00:00',
            'time_out'=>'17:00:00',
            'date' => '2018-04-09',
            'shift' => 1,
            'info' => 'Masuk',
            'additional' => 'Tepat',
            'overtime' => 0,
            'overtime_status' => '-',
            'overtime_permit' => 'N'
          ],
          [
            'id'=> 2,
            'employee_id'=>2,
            'time_in'=>'07:00:00',
            'time_out'=>'17:00:00',
            'date' => '2018-04-09',
            'shift' => 1,
            'info' => 'Masuk',
            'additional' => 'Tepat',
            'overtime' => 1,
            'overtime_status' => 'Lembur',
            'overtime_permit' => 'Y'
          ],
          [
            'id'=> 3,
            'employee_id'=>1,
            'time_in'=>'07:00:00',
            'time_out'=>'17:00:00',
            'date' => '2018-04-10',
            'shift' => 1,
            'info' => 'Masuk',
            'additional' => 'Tepat',
            'overtime' => 2,
            'overtime_status' => 'Lembur',
            'overtime_permit' => 'Y'
          ],
          [
            'id'=> 4,
            'employee_id'=>2,
            'time_in'=>'07:00:00',
            'time_out'=>'17:00:00',
            'date' => '2018-04-10',
            'shift' => 1,
            'info' => 'Masuk',
            'additional' => 'Tepat',
            'overtime' => 0,
            'overtime_status' => '-',
            'overtime_permit' => 'N'
          ],
        ]);
    }
}
