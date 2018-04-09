<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	 $this->call(DatabaseUnseeder::class);
         $this->call(UsersSeeder::class);
         $this->call(EmployeesSeeder::class);
         $this->call(PositionsSeeder::class);
         $this->call(AllowancesSeeder::class);
         $this->call(PresencesSeeder::class);
    }
}
