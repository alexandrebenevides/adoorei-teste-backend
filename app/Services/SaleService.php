<?php

namespace App\Services;

use App\Exceptions\CanceledSaleException;
use App\Repositories\SaleRepository;
use App\Repositories\ProductRepository;
use App\Models\Sale;

class SaleService
{
    private $saleRepository;
    private $productRepository;

    public function __construct(SaleRepository $saleRepository, ProductRepository $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllSales(bool $onlyActives)
    {
        $sales = $this->saleRepository->all($onlyActives)->map(function ($sale) {
            return $this->formatSaleData($sale);
        });

        return $sales;
    }

    public function getSale(int $saleId)
    {
        $sale = $this->saleRepository->find($saleId);

        if (!is_null($sale->canceled_at)) {
            throw new CanceledSaleException();
        }

        return $this->formatSaleData($sale);
    }

    public function store(array $products)
    {
        $sale = $this->saleRepository->create();
        $this->storeProducts($sale->id, $products);

        return $sale;
    }

    public function storeProducts(int $saleId, array $products)
    {
        $sale = $this->saleRepository->find($saleId);

        if (!is_null($sale->canceled_at)) {
            throw new CanceledSaleException();
        }

        $totalPrice = 0;
        $productsSale = [];

        foreach ($products as $product) {
            $product['price'] = $this->productRepository->getProductPrice($product['product_id']);
            $totalPrice += $product['price'] * $product['amount'];
        
            $productsSale[] = [
                'product_id' => $product['product_id'],
                'amount' => $product['amount']
            ];
        }

        $sale->products()->attach($productsSale);
        $sale->update(['total_price' => $sale->total_price + $totalPrice]);

        return $sale;
    }

    public function cancelSale(int $saleId)
    {
        $sale = $this->saleRepository->find($saleId);

        if (!is_null($sale->canceled_at)) {
            throw new CanceledSaleException();
        }

        return $this->saleRepository->cancel($saleId);
    }

    private function formatSaleData(Sale $sale) {
        return [
            'sales_id' => $sale->id,
            'amount' => $sale->total_price,
            'products' => $sale->products->map(function($product) {
                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'amount' => $product->pivot->amount,
                ];
            }),
        ];
    }
}