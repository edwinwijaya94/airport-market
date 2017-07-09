<?php

use Illuminate\Database\Seeder;

class GarendongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('garendongs')->insert(array(
        	array('user_id'=>1,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>2,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>3,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>4,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>5,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>6,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>7,'rating'=>5,'num_rating'=>10),
        	array('user_id'=>8,'rating'=>5,'num_rating'=>10),
        ));
    }
}
