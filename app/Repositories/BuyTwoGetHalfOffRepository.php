<?php

namespace App\Repositories;

use App\Contracts\OfferContract;
use App\Models\Cart;
use App\Models\Product;

class BuyTwoGetHalfOffRepository implements OfferContract {
    private $cart;
    private $product;
    const NAME = 'buy_1_get_half_off';

    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }

    public function countEvens($low, $high){
        $count = 0;
        for ($i = $low; $i<=$high; $i++){
            if($i % 2 == 0){
                $count ++;
            }
        }
        return $count;
    }
    public function apply(){
        return $this->countEvens(1, $this->cart->products[$this->product->getName()]['quantity']) * ($this->product->getPrice()/2);
    }

}
