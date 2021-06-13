<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use App\Repositories\InventoryRepository;
use Illuminate\Console\Command;
use App\Helpers\CSVHelper;
class ShoppingCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $data = CSVHelper::readCSV(storage_path('csv/inventory.csv'));

        $inventory = InventoryRepository::getInventory();

        foreach ($data as $datum){
            $inventory->add(new Product($datum));
        }
        $cart = new CartRepository(new Cart());

        while (1){
            $command = $this->ask('');
            $command = explode(" ", $command);
            if(!in_array(strtolower($command[0]), config('actions.allowed_actions'))){
                echo "Invalid command!\n";
            }
            try{
                if($command[0] === 'add'){
                    $product = $inventory->getProduct($command[1]);
                    $cart->add($product, $command[2]);
                }else if($command[0] == 'bill'){
                    $cart->getBill();
                }else if($command[0] == 'checkout'){
                    $cart->checkout();
                    return 0;
                }else if($command[0] == 'offer'){
                    $product = $inventory->getProduct($command[2]);
                    $cart->applyOffer($command[1], $product);
                }
            } catch (\Exception $exception){
                echo "Invalid command!\n";
            }
        }
    }


}
