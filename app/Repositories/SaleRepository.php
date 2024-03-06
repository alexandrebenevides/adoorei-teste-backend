<?php

namespace App\Repositories;

use App\Models\Sale;
use Carbon\Carbon;

class SaleRepository
{
    public function all(bool $onlyActives)
    {
        return Sale::when($onlyActives, function ($query, bool $onlyActives) {
            $query->whereNull('canceled_at');
        })->get();
    }

    public function find(int $saleId)
    {
        return Sale::whereId($saleId)->first();
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

    public function cancel(int $saleId)
    {
        $sale = $this->find($saleId);
        $sale->canceled_at = Carbon::now();
        $sale->save();
        
        return $sale;
    }
}