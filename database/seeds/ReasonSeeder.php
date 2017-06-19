<?php

use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('pgsql')->table('reasons')->insert([
            ['reason' => 'Pelayanan garendong buruk'],
            ['reason' => 'Kualitas pesanan buruk'],
            ['reason' => 'Durasi pemesanan lama'],
        ]);
    }
}