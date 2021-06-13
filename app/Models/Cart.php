<?php

namespace App\Models;

class Cart
{
    public $products = [];
    public $subTotal;
    public $discount;
    public $total;


    public function __construct()
    {
        $this->products = [];
        $this->subTotal = $this->discount = $this->subTotal = 0;
    }
    public function getProductQuantity(Product $product){
        return $this->products[$product->getName()]['quantity'];
    }
}
