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
        	array('name'=>'Bolu', 'price'=>25000, 'desc'=>'bolu coklat', 'product_img'=>'http://mayasaribakery.com/sites/default/files/product/bolu%20peuyeum%202.jpg', 'store_id'=>1),
            array('name'=>'Brownies', 'price'=>35000, 'desc'=>'brownies panggang', 'product_img'=>'http://mayasaribakery.com/sites/default/files/product/IMG_1864%20%28FILEminimizer%29.JPG', 'store_id'=>1),
            array('name'=>'Pisang Bolen', 'price'=>30000, 'desc'=>'pisang bolen isi 10', 'product_img'=>'http://mayasaribakery.com/sites/default/files/product/Optimized-pisang%20bolen%20keju-42.000.JPG', 'store_id'=>1),
            array('name'=>'Lemon Tea', 'price'=>15000, 'desc'=>'es teh lemon', 'product_img'=>'http://cdn2.stylecraze.com/wp-content/uploads/2015/05/lemon-tea.jpg', 'store_id'=>2),
            array('name'=>'Nasi Goreng', 'price'=>40000, 'desc'=>'nasi goreng telor', 'product_img'=>'http://img.taste.com.au/lxwN-bcZ/taste/2016/11/leftover-turkey-nasi-goreng-101377-1.jpeg', 'store_id'=>2),
            array('name'=>'Milk Tea', 'price'=>20000, 'desc'=>'teh susu', 'product_img'=>'http://www.recipe4living.com/assets/itemimages/400/400/3/default_0606e1fb4410e9c56f5b5bc5b25024bd_dreamstime_s_70309932.jpg', 'store_id'=>3),
        ));
    }
}