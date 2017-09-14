<?php

use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('stores')->insert(array(
        	array('airport_code'=>'BDO','name'=>'Mayasari'),
            array('airport_code'=>'BDO','name'=>'Executive Lounge'),
            array('airport_code'=>'BDO','name'=>'I - Cup'),
            array('airport_code'=>'CGK','name'=>'Beard Papa & Crispy Puffs'),
            array('airport_code'=>'CGK','name'=>'Cempaka Resto')
        ));
    }
}