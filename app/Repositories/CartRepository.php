<?php
namespace App\Repositories;


use App\Helpers\RoundingHelper;
use App\Models\Cart;
use App\Models\Product;

class CartRepository{

    public $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        echo "Empty Cart\n" ;
    }

    public function add(Product $product, $quantity){

        $inventory = InventoryRepository::getInventory();

        $stock = $inventory->getStockAvailable($product);

        if($stock == 0){
            echo $product->getName() . " is out of stock!\n";
            return;
        }

        if(isset($this->cart->products[$product->getName()])){
            $current_quantity = $this->cart->getProductQuantity($product);
            $this->cart->products[$product->getName()]['quantity'] = $current_quantity + $quantity;
        }else{
            $this->cart->products[$product->getName()] = ['price'=>$product->getPrice(), 'quantity'=>$quantity];
        }
        $this->calculateTotals();
        echo 'Added ' . $product->getName() . ' ' .$quantity . "\n";
    }

    public function remove(Product $product, $quantity){
        if(!isset($this->cart->products[$product->getName()])){
            echo $product->getName() . " does not exists in cart\n";
            return;
        }
        $current_quantity = $this->cart->getProductQuantity($product);
        if($current_quantity  >= $quantity){
            $current_quantity = $current_quantity - $quantity;
            if($current_quantity == 0){
                unset($this->cart->products[$product->getName()]);
            }else{
                $this->cart->products[$product->getName()]['quantity'] = $current_quantity;
            }
        }else{
            echo 'Quantity given to remove is greater than the current quantity in cart';
            return;
        }
        $this->calculateTotals();
        echo 'Removed ' . $product->getName() . ' ' .$quantity . "\n";
    }

    public function applyOffer($offer, Product $product){
        $offer = config('offer.'.$offer);
        $offerRepo = new $offer($this->cart, $product);
        $this->cart->discount += $offerRepo->apply();
        $this->calculateTotals();
        echo "Offer Added\n";
    }
    public function calculateTotals(){
        $subTotal = 0;
        $total = 0;
        foreach ($this->cart->products as $product){
            $subTotal += $product['price'] * $product['quantity'];
            $total += $product['price'] * $product['quantity'];
        }
        $this->cart->subTotal = RoundingHelper::bankersRound($subTotal, 2);
        $this->cart->total = RoundingHelper::bankersRound($total - $this->cart->discount, 2);
    }
    public function getBill(){
        echo 'Subtotal: '.$this->cart->subTotal.', Discount: '.$this->cart->discount.', Total: ' . $this->cart->total . "\n";
    }
    public function checkout(){
        echo 'Done';
    }
}
