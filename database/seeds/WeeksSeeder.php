<?php

use Illuminate\Database\Seeder;

class WeeksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weeks')->insert([
          [
            'id'=> 1,
            'name'=>'Minggu 1'
          ],
          [
            'id'=> 2,
            'name'=>'Minggu 2'
          ],
          [
            'id'=> 3,
            'name'=>'Minggu 3'
          ],
          [
            'id'=> 4,
            'name'=>'Minggu 4'
          ],
        ]);
    }
}
