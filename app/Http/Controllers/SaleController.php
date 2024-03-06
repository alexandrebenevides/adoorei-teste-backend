<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SaleService;
use App\Helpers\RequestValidatorHelper;

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
     *     summary="Lista todas as vendas realizadas e que estão ativas",
     *     @OA\Response(response="200", description="Sucesso")
     * )
     */
    public function list()
    {
        $sales = $this->saleService->getAllSales(true);
        return response()->json($sales);
    }

    /**
     * @OA\Get(
     *     path="/api/sale/{id}",
     *     tags={"Venda"},
     *     summary="Consulta uma venda ativa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da venda a ser consultada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="404", description="Venda não encontrada")
     * )
     */
    public function get($id)
    {
        RequestValidatorHelper::make(['id' => $id], [
            'id' => 'required|integer|exists:sales,id',
        ]);

        $sale = $this->saleService->getSale($id);
        return response()->json($sale);
    }

    /**
     * @OA\Post(
     *     path="/api/sale",
     *     tags={"Venda"},
     *     summary="Cadastra uma nova venda com um ou mais produtos",
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
        RequestValidatorHelper::make($request->all(), [
            '*.product_id' => 'required|integer|exists:products,id',
            '*.amount' => 'required|integer|min:1',
        ]);

        $this->saleService->store($request->all());
        return response()->json(['message' => 'A venda foi cadastrada com sucesso.'], Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *     path="/api/sale/{id}/products",
     *     tags={"Venda"},
     *     summary="Cadastra novos produtos em uma venda ativa",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID da venda",
     *          @OA\Schema(type="integer")
     *     ),
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
     *     @OA\Response(response="201", description="Sucesso"),
     *     @OA\Response(response="404", description="Venda não encontrada")
     * )
     */
    public function storeProducts(int $id, Request $request)
    {
        RequestValidatorHelper::make(array_merge(['id' => $id], ['products' => $request->all()]), [
            'id' => 'required|integer|exists:sales,id',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.amount' => 'required|integer|min:1',
        ]);

        $sale = $this->saleService->storeProducts($id, $request->all());
        return response()->json(['message' => 'Os produtos foram adicionados na venda.'], Response::HTTP_CREATED);
    }

    /**
     * @OA\Delete(
     *     path="/api/sale/{id}",
     *     tags={"Venda"},
     *     summary="Cancela uma venda específica",
     *     @OA\Parameter(
    *          name="id",
    *          in="path",
    *          required=true,
    *          description="ID da venda a ser cancelada",
    *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Sucesso"),
     *     @OA\Response(response="404", description="Venda não encontrada")
     * )
     */
    public function cancel($id)
    {
        RequestValidatorHelper::make(['id' => $id], [
            'id' => 'required|integer|exists:sales,id',
        ]);

        $sale = $this->saleService->cancelSale($id);
        return response()->json(['message' => 'A venda foi cancelada com sucesso.']);
    }
}