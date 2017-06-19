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
        // call uses table seeder class
        $this->call('OrderLinesTableSeeder');
        $this->call('OrdersTableSeeder');
        $this->call('UsersTableSeeder');
        //this message shown in your terminal after running db:seed command
        // $this->command->info("Order Line table seeded");
    }
}
