<?php

use Illuminate\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('employees')->insert([
          [
            'id'=> 1,
            'name'=>'Admin Arief',
            'nik'=>'1234123412341234',
            'id_card'=>'id12341234',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089683523727',
            'education' => 'Sarjana',
            'account_number' => '12341234',
            'profile_picture' => '',
            'position_id' => '1',
            'user_id' => '1'
          ],
          [
            'id'=> 2,
            'name'=>'Karyawan Arief',
            'nik'=>'1234123412341235',
            'id_card'=>'id12341235',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089683523721',
            'education' => 'Sarjana',
            'account_number' => '12341235',
            'profile_picture' => '',
            'position_id' => '2',
            'user_id' => '2'
          ],
          [
            'id'=> 3,
            'name'=>'Manajer Arief',
            'nik'=>'1234123412341236',
            'id_card'=>'id12341236',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089683523722',
            'education' => 'Sarjana',
            'account_number' => '12341236',
            'profile_picture' => '',
            'position_id' => '3',
            'user_id' => '3'
          ],
          [
            'id'=> 4,
            'name'=>'Admin Azka',
            'nik'=>'1234123412341237',
            'id_card'=>'id12341237',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089683523723',
            'education' => 'Sarjana',
            'account_number' => '12341237',
            'profile_picture' => '',
            'position_id' => '1',
            'user_id' => '4'
          ],
        ]);
    }
}
