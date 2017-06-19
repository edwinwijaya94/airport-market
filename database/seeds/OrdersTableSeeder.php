<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('orders')->insert(array(
        	array('customer_id'=>1,'total_product'=>5,'order_type'=>'mobile','garendong_id'=>1),
        	array('customer_id'=>2,'total_product'=>4,'order_type'=>'mobile','garendong_id'=>1),
        	array('customer_id'=>3,'total_product'=>2,'order_type'=>'sms','garendong_id'=>1),
        	array('customer_id'=>4,'total_product'=>5,'order_type'=>'mobile','garendong_id'=>2),
        	array('customer_id'=>5,'total_product'=>3,'order_type'=>'mobile','garendong_id'=>2),
        	array('customer_id'=>1,'total_product'=>1,'order_type'=>'sms','garendong_id'=>3),
        	array('customer_id'=>2,'total_product'=>1,'order_type'=>'sms','garendong_id'=>4),
        	array('customer_id'=>3,'total_product'=>2,'order_type'=>'mobile','garendong_id'=>5),
        ));
    }
}