<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::get('/products', [ProductController::class, 'list']);

Route::post('/sale', [SaleController::class, 'store']);