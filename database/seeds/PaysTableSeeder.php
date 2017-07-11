<?php

use Illuminate\Database\Seeder;

class PaysTableSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('pays')->insert(array(
        	array('parameter'=>'Tarif Dasar','constant'=>5000),
        	array('parameter'=>'Tarif Jarak','constant'=>10),
        ));
    }
}