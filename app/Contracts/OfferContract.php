<?php

namespace App\Contracts;

use App\Models\Cart;
use App\Models\Product;

interface OfferContract{

    public function __construct(Cart $cart, Product $product);

    public function apply();

}
