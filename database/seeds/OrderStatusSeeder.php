<?php

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('pgsql')->table('order_statuses')->insert([
            ['status' => 'Pesanan Anda berhasil diproses'],
            ['status' => 'Pesanan Anda sedang dibelanjakan'],
            ['status' => 'Pesanan Anda sedang dikirim'],
        ]);
    }
}
