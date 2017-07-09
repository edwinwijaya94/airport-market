<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql_2')->table('users')->insert(array(
        	array('name'=>'user1','username'=>'user1','address'=>'address1','phone_number'=>'081234567890'),
        	array('name'=>'user2','username'=>'user2','address'=>'address2','phone_number'=>'081234567890'),
        	array('name'=>'user3','username'=>'user3','address'=>'address3','phone_number'=>'081234567890'),
        	array('name'=>'user4','username'=>'user4','address'=>'address4','phone_number'=>'081234567890'),
        	array('name'=>'user5','username'=>'user5','address'=>'address5','phone_number'=>'081234567890'),
        	array('name'=>'user6','username'=>'user6','address'=>'address6','phone_number'=>'081234567890'),
        	array('name'=>'user7','username'=>'user7','address'=>'address7','phone_number'=>'081234567890'),
        	array('name'=>'user8','username'=>'user8','address'=>'address8','phone_number'=>'081234567890'),
        ));
    }
}
