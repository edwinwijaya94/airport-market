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
        
        $this->call(UsersTableSeeder::class);
        $this->call(OrderStatusSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderLinesTableSeeder::class);
        
    }
}
