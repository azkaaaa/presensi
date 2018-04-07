<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          [
            'id'=> 1,
            'name'=>'Admin Arief',
            'email'=>'arozenh@gmail.com',
            'password'=>Hash::make('12341234'),
            'level' => 'Admin',
            'status' => '1'
          ],
          [
            'id'=> 2,
            'name'=>'Karyawan Arief',
            'email'=>'arief_11@live.com',
            'password'=>Hash::make('12341234'),
            'level' => 'Karyawan',
            'status' => '1'
          ],
          [
            'id'=> 3,
            'name'=>'Manajer Arief',
            'email'=>'ariefdwityo11@gmail.com',
            'password'=>Hash::make('12341234'),
            'level' => 'Manajer',
            'status' => '1'
          ],
          [
            'id'=> 4,
            'name'=>'Admin Azka',
            'email'=>'azka642@gmail.com',
            'password'=>Hash::make('12341234'),
            'level' => 'Admin',
            'status' => '1'
          ],
        ]);
    }
}
