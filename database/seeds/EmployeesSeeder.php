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
            'position_id' => '2',
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
            'position_id' => '1',
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
            'position_id' => '5',
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
            'position_id' => '2',
            'user_id' => '4'
          ],
          [
            'id'=> 5,
            'name'=>'Karyawan Satu',
            'nik'=>'1244123412341237',
            'id_card'=>'id12341222',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089983526623',
            'education' => 'Sarjana',
            'account_number' => '12341465',
            'profile_picture' => '',
            'position_id' => '1',
            'user_id' => '2'
          ],
          [
            'id'=> 6,
            'name'=>'Karyawan Dua',
            'nik'=>'1244123412344321',
            'id_card'=>'id12341298',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089983527788',
            'education' => 'Sarjana',
            'account_number' => '12345566',
            'profile_picture' => '',
            'position_id' => '3',
            'user_id' => '2'
          ],
          [
            'id'=> 7,
            'name'=>'Karyawan Tiga',
            'nik'=>'1244123412348976',
            'id_card'=>'id12349527',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '0899835212354',
            'education' => 'Sarjana',
            'account_number' => '12341629',
            'profile_picture' => '',
            'position_id' => '4',
            'user_id' => '2'
          ],
          [
            'id'=> 8,
            'name'=>'Karyawan Empat',
            'nik'=>'1244123412340987',
            'id_card'=>'id12344521',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089983526745',
            'education' => 'Sarjana',
            'account_number' => '12348634',
            'profile_picture' => '',
            'position_id' => '3',
            'user_id' => '2'
          ],
          [
            'id'=> 9,
            'name'=>'Karyawan Lima',
            'nik'=>'1244123412345672',
            'id_card'=>'id12340987',
            'birthday' => '2018-03-16',
            'religion' => 'Islam',
            'address' => 'Bekasi',
            'phone' => '089983528725',
            'education' => 'Sarjana',
            'account_number' => '12340936',
            'profile_picture' => '',
            'position_id' => '4',
            'user_id' => '2'
          ],
        ]);
    }
}
