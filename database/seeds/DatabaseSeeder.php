<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('OrderLinesTableSeeder');
        // $this->call('OrdersTableSeeder');
        $this->call(UsersTableSeeder::class);
        // $this->call('GarendongsTableSeeder');
        $this->call(OrderStatusSeeder::class);
        // $this->call(ReasonSeeder::class);
        // $this->call(DictionarySeeder::class);
        $this->call(RoleSeeder::class);
        // $this->call('PaysTableSeeder');
    }
}
