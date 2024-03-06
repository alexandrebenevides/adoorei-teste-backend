<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::get('/products', [ProductController::class, 'list']);

Route::get('/sales', [SaleController::class, 'list']);
Route::get('/sale/{id}', [SaleController::class, 'get']);
Route::post('/sale', [SaleController::class, 'store']);
Route::delete('/sale/{id}', [SaleController::class, 'cancel']);