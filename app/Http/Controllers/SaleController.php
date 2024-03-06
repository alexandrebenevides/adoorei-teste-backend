<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SaleService;

class SaleController extends Controller
{
    private $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    /**
     * @OA\Get(
     *     path="/api/sales",
     *     tags={"Venda"},
     *     summary="Listagem de todas as vendas realizadas que estão ativas",
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function list()
    {
        $sales = $this->saleService->getAllSales(true);
        return response()->json($sales);
    }

    /**
     * @OA\Post(
     *     path="/api/sale",
     *     tags={"Venda"},
     *     summary="Realiza o cadastro de uma nova venda com um ou mais produtos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="product_id", type="integer", example=2),
     *                 @OA\Property(property="amount", type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Sucesso")
     * )
     */
    public function store(Request $request)
    {
        $this->saleService->store($request->all());
        return response()->json(['message' => 'Venda cadastrada com sucesso.'], Response::HTTP_CREATED);
    }
}