<?php

use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
          [
            'id'=> 1,
            'name'=>'Pegawai Cafe',
            'salary'=>'70000',
            'transport'=>'10000'
          ],
          [
            'id'=> 2,
            'name'=>'Pegawai Warnet',
            'salary'=>'50000',
            'transport'=>'15000'
          ],
          [
            'id'=> 3,
            'name'=>'Manajer',
            'salary'=>'100000',
            'transport'=>'20000'
          ],
        ]);
    }
}
