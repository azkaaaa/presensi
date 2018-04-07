<?php

use Illuminate\Database\Seeder;

class AllowancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('allowances')->insert([
          [
            'id'=> 1,
            'name'=>'Transport',
            'price'=>'100000'
          ],
          [
            'id'=> 2,
            'name'=>'Tunjangan Kesehatan',
            'price'=>'150000'
          ],
        ]);
    }
}
