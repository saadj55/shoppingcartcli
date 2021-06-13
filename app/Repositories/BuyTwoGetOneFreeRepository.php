<?php

namespace App\Repositories;

use App\Contracts\OfferContract;
use App\Models\Cart;
use App\Models\Product;

class BuyTwoGetOneFreeRepository implements OfferContract {

    private $cart;
    private $product;
    const NAME = 'buy_2_get_1_free';

    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }

    public function countOdds($low, $high){
        $count = 0;
        for ($i = $low; $i<=$high; $i++){
            if($i % 3 == 0){
                $count++;
            }
        }
        return $count;
    }

    public function apply(){
        $total_discount = 0;
        foreach ($this->cart->products as $name => $product){
            if ($name == $this->product->getName()) {
                $total_discount = $this->countOdds(1, $product['quantity']) * $this->product->getPrice();
            }
        }

        return $total_discount;
    }

}
