<?php

use Illuminate\Database\Seeder;

class OrderLinesTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('order_lines')->insert(array(
        	array('order_id'=>'1','product_id'=>1,'quantity'=>2),
        	array('order_id'=>'1','product_id'=>2,'quantity'=>3),
        	array('order_id'=>'2','product_id'=>2,'quantity'=>5),
        	array('order_id'=>'2','product_id'=>3,'quantity'=>1),
        ));
	}
}
