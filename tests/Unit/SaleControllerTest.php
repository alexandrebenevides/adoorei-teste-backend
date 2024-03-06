<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class SaleControllerTest extends TestCase
{
    /**
     * Testa se a criação de uma venda retorna uma resposta JSON
     * e se o código de status HTTP é 201 (Created).
     */
    public function testStoreSaleReturnsSuccessJsonResponse()
    {
        $data = [
            ['product_id' => 1, 'amount' => 2],
            ['product_id' => 2, 'amount' => 3],
        ];

        $response = $this->post('/api/sale', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'A venda foi cadastrada com sucesso.']);
    }

    /**
     * Testa se a listagem de vendas retorna uma resposta JSON
     * na estrutura correta.
     */
    public function testListSalesReturnsJsonResponse()
    {
        $response = $this->get('/api/sales');
        
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                '*' => [
                    'sales_id',
                    'amount',
                    'products' => [
                        '*' => [
                            'product_id',
                            'name',
                            'price',
                            'amount'
                        ]
                    ]
                ]
            ]);
    }

    /**
     * Testa se a consulta de uma venda retorna uma resposta JSON
     * na estrutura correta.
     */
    public function testGetSaleReturnsJsonResponse()
    {
        $response = $this->get('/api/sale/1');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'sales_id',
                'amount',
                'products' => [
                    '*' => [
                        'product_id',
                        'name',
                        'price',
                        'amount'
                    ]
                ]
            ]);
    }


    /**
     * Testa se a adição de produtos em uma venda retorna uma resposta JSON
     * e se o código de status HTTP é 201 (Created).
     */
    public function testStoreProductsInSaleReturnsJsonSuccessResponse()
    {
        $data = [
            ['product_id' => 3, 'amount' => 1],
        ];

        $response = $this->post('/api/sale/1/products', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Os produtos foram adicionados na venda.']);
    }

    /**
     * Testa se o cancelamento de uma venda retorna uma resposta JSON
     * e se o código de status HTTP é 200 (OK).
     */
    public function testCancelSaleReturnsJsonSuccessResponse()
    {
        $response = $this->delete('/api/sale/1');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'A venda foi cancelada com sucesso.']);
    }
}