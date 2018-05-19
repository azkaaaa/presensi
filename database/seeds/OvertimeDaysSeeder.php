<?php

use Illuminate\Database\Seeder;

class OvertimeDaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('overtime_days')->insert([
          [
            'id'=> 1,
            'name'=>'Senin'
          ],
          [
            'id'=> 2,
            'name'=>'Selasa'
          ],
          [
            'id'=> 3,
            'name'=>'Rabu'
          ],
          [
            'id'=> 4,
            'name'=>'Kamis'
          ],
          [
            'id'=> 5,
            'name'=>'Jumat'
          ],
          [
            'id'=> 6,
            'name'=>'Sabtu'
          ],
          [
            'id'=> 7,
            'name'=>'Minggu'
          ],
          [
            'id'=> 8,
            'name'=>'Tidak Lembur'
          ],
        ]);
    }
}
