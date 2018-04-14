<?php

use Illuminate\Database\Seeder;

class DatabaseUnseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('positions')->truncate();
        DB::table('employees')->truncate();
        DB::table('users')->truncate();
        DB::table('presences')->truncate();
    }
}
