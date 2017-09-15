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
        	array('name'=>'Bolu', 'price'=>25000, 'desc'=>'bolu coklat', 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Brownies', 'price'=>35000, 'desc'=>'brownies panggang', 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Pisang Bolen', 'price'=>30000, 'desc'=>'pisang bolen isi 10', 'product_img'=>'a.com', 'store_id'=>1),
            array('name'=>'Lemon Tea', 'price'=>15000, 'desc'=>'es teh lemon', 'product_img'=>'a.com', 'store_id'=>2),
            array('name'=>'Nasi Goreng', 'price'=>40000, 'desc'=>'nasi goreng telor', 'product_img'=>'a.com', 'store_id'=>2),
            array('name'=>'Milk Tea', 'price'=>20000, 'desc'=>'teh susu', 'product_img'=>'a.com', 'store_id'=>3),
        ));
    }
}