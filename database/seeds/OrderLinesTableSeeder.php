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
        	array('order_id'=>'1','product_id'=>1,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'1','product_id'=>2,'quantity'=>400,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'1','product_id'=>3,'quantity'=>200,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'1','product_id'=>4,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'1','product_id'=>5,'quantity'=>300,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'2','product_id'=>1,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'2','product_id'=>2,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'2','product_id'=>3,'quantity'=>200,'unit_id'=>1,'is_priority'=>true),
        	array('order_id'=>'2','product_id'=>4,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'3','product_id'=>1,'quantity'=>400,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'3','product_id'=>2,'quantity'=>200,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'4','product_id'=>1,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'4','product_id'=>2,'quantity'=>300,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'4','product_id'=>3,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'4','product_id'=>4,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'4','product_id'=>5,'quantity'=>200,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'5','product_id'=>1,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'5','product_id'=>2,'quantity'=>400,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'5','product_id'=>3,'quantity'=>200,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'6','product_id'=>1,'quantity'=>500,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'7','product_id'=>1,'quantity'=>300,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'8','product_id'=>1,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
			array('order_id'=>'8','product_id'=>2,'quantity'=>100,'unit_id'=>1,'is_priority'=>true),
        ));
	}
}
