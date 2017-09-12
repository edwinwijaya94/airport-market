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
        DB::connection('pgsql')->table('users')->insert(array(
        	array('name'=>'user1','role_id'=>1,'username'=>'user1','password'=>'abc','phone_number'=>'081234567891','fake'=>1),
        	array('name'=>'user2','role_id'=>1,'username'=>'user2','password'=>'abc','phone_number'=>'081234567892','fake'=>1),
        	array('name'=>'user3','role_id'=>1,'username'=>'user3','password'=>'abc','phone_number'=>'081234567893','fake'=>1),
        ));
    }
}