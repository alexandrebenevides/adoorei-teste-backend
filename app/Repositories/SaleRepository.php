<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    public function all($onlyActives)
    {
        return Sale::when($onlyActives, function ($query, bool $onlyActives) {
            $query->whereNull('canceled_at');
        })->get();
    }

    public function find($id)
    {
        return Sale::whereId($id)->first();
    }

    public function create(array $products)
    {
        $totalPrice = 0;
        $productsSale = [];

        foreach ($products as $product) {
            $totalPrice += $product['price'] * $product['amount'];
        
            $productsSale[] = [
                'product_id' => $product['product_id'],
                'amount' => $product['amount']
            ];
        }

        $sale = Sale::create(['total_price' => $totalPrice]);
        $sale->products()->attach($productsSale);

        return $sale;
    }
}