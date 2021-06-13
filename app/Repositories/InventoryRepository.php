<?php
namespace App\Repositories;

use App\Models\Product;

class InventoryRepository {

    public $products = [];
    private static $inventory;


    private final function __construct()
    {

    }

    public static function getInventory() {
        if (!isset(self::$inventory)) {
            self::$inventory = new InventoryRepository();
        }

        return self::$inventory;
    }

    public function add(Product $product){

        if(isset($this->products[$product->getName()])){
            $current_quantity = $this->products[$product->getName()]['available'];
            $this->products[$product->getName()]['available'] = $current_quantity + $product['available'];
        }else{
            $this->products[$product->getName()] = ['price'=>$product->getPrice(), 'available'=>$product->getStockAvailable()];
        }

    }
    public function getProduct($name){
        $data = $this->products[$name];
        $data['name'] = $name;
        return new Product($data);
    }
    public function getStockAvailable(Product $product){
        return $this->products[$product->getName()]['available'];
    }


}
