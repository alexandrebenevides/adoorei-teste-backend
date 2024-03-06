<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testListReturnsJsonResponse()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'description']
        ]);
    }
}