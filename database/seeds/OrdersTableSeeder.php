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
        	array('customer_id'=>1,'store_id'=>1,'total_product'=>2,'customer_location'=>'terminal domestik'),
        	array('customer_id'=>2,'store_id'=>1,'total_product'=>2,'customer_location'=>'terminal internasional'),
        ));
    }
}