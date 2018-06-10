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
            'name'=>'Koki',
            'salary'=>'70000',
            'transport'=>'10000'
          ],
          [
            'id'=> 2,
            'name'=>'Pelayan',
            'salary'=>'50000',
            'transport'=>'15000'
          ],
          [
            'id'=> 3,
            'name'=>'OB',
            'salary'=>'100000',
            'transport'=>'20000'
          ],
          [
            'id'=> 4,
            'name'=>'Kasir',
            'salary'=>'100000',
            'transport'=>'20000'
          ],
          [
            'id'=> 5,
            'name'=>'Manajer',
            'salary'=>'100000',
            'transport'=>'20000'
          ],
        ]);
    }
}
