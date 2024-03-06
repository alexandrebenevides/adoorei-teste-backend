<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find(int $productId)
    {
        return Product::whereId($productId)->first();
    }

    public function getProductPrice(int $productId)
    {
        return $this->find($productId)->price;
    }
}