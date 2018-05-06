<?php

use Illuminate\Database\Seeder;

class ShiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
          [
            'id'=> 1,
            'name'=>'Pagi'
          ],
          [
            'id'=> 2,
            'name'=>'Malam'
          ],
        ]);
    }
}
