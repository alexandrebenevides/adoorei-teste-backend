<?php

namespace App\Services;

use App\Repositories\SaleRepository;
use App\Repositories\ProductRepository;

class SaleService
{
    private $saleRepository;
    private $productRepository;

    public function __construct(SaleRepository $saleRepository, ProductRepository $productRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
    }

    public function getAllSales($onlyActives)
    {
        $sales = $this->saleRepository->all($onlyActives)->map(function ($sale) {
            return $this->formatSaleData($sale);
        });

        return $sales;
    }

    public function getSale($id)
    {
        $sale = $this->saleRepository->find($id);

        if (is_null($sale) || !is_null($sale->canceled_at)) {
            return null;
        }

        return $this->formatSaleData($sale);
    }

    public function store(array $products)
    {
        $products = array_map(function ($product) {
            $product['price'] = $this->productRepository->getProductPrice($product['product_id']);
            return $product;
        }, $products);

        return $this->saleRepository->create($products);
    }

    public function cancelSale($id)
    {
        $sale = $this->saleRepository->find($id);

        if (is_null($sale) || !is_null($sale->canceled_at)) {
            return null;
        }

        return $this->saleRepository->cancel($id);
    }

    private function formatSaleData($sale) {
        return [
            'sales_id' => $sale->id,
            'amount' => $sale->total_price,
            'products' => $sale->products->map(function ($product) {
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