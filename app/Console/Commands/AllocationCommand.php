<?php

namespace App\Console\Commands;

use App\Order;
use App\Garendong;
use Illuminate\Console\Command;

class AllocationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allocation:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alokasi garendong';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $orders = Order::all();

        foreach ($orders as $order) {
            $minAllocation = Garendong::min('number_of_allocation');
            $garendong = Garendong::where('number_of_allocation', '=', $minAllocation)
                                    ->limit(1)
                                    ->get();
            if($order->garendong_id == 0){
                $order->garendong_id = $garendong[0]->id;
                $allocatedGarendong = Garendong::find($garendong[0]->id);
                $allocatedGarendong->number_of_allocation++;
                $allocatedGarendong->save();
            }
            $order->order_status = 2;   
            $order->save();
        }

        return 'Garendong berhasil dialokasikan';
    }

    public function allocate(){
        
    }
}
