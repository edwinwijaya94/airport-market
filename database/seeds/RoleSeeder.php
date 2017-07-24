<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('pgsql_2')->table('roles')->insert([
            ['name' => 'pembeli'],
            ['name' => 'garendong'],
            ['name' => 'petugas Pasar'],
            ['name' => 'pemerintah'],
        ]);
    }
}
