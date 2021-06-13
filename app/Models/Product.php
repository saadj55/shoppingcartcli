<?php

namespace App\Models;
class Product {

    private $name;
    private $price;
    public $stock_available;


    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->stock_available = $data['available'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getStockAvailable()
    {
        return $this->stock_available;
    }

}
