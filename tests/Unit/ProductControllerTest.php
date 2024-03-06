<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class ProductControllerTest extends TestCase
{
    /**
     * Testa se a listagem de produtos retorna uma resposta JSON
     * na estrutura correta.
     */
    public function testListProductsReturnsJsonResponse()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['*' => ['id', 'name', 'price', 'description']]);
    }
}