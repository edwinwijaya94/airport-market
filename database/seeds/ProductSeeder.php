<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert some dummy records
        DB::connection('pgsql')->table('products')->insert(array(
        	array('name'=>'Bolu', 'price'=>25000, 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Brownies', 'price'=>35000, 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Pisang Bolen', 'price'=>30000, 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Lemon Tea', 'price'=>15000, 'product_img'=>'a.com', 'store_id'=>2),
            array('name'=>'Nasi Goreng', 'price'=>40000, 'product_img'=>'a.com', 'store_id'=>2),
            array('name'=>'Milk Tea', 'price'=>20000, 'product_img'=>'a.com', 'store_id'=>3),
        ));
    }
}