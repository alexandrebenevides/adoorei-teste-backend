<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Produtos"},
     *     summary="Listagem de todos os produtos",
     *     description="Obtêm toda a listagem de produtos cadastrados",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function list()
    {
        $products = $this->productService->getAllProducts();
        return response()->json($products);
    }
}