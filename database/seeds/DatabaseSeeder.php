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
<<<<<<< HEAD
        // call uses table seeder class
        $this->call('OrderLinesTableSeeder');
        $this->call('OrdersTableSeeder');
        $this->call('UsersTableSeeder');
        //this message shown in your terminal after running db:seed command
        // $this->command->info("Order Line table seeded");
=======
        $this->call(OrderStatusSeeder::class);
        $this->call(ReasonSeeder::class);
>>>>>>> 2a8b60c799c237cf60c8fda9c1e2ad481ee1c1a0
    }
}
