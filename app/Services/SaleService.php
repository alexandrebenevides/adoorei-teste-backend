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

    public function store(array $products)
    {
        $products = array_map(function ($product) {
            $product['price'] = $this->productRepository->getProductPrice($product['product_id']);
            return $product;
        }, $products);

        return $this->saleRepository->create($products);
    }
}