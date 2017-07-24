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
            ['reason' => 'pelayanan garendong buruk'],
            ['reason' => 'kualitas pesanan buruk'],
            ['reason' => 'durasi pemesanan lama'],
        ]);
    }
}