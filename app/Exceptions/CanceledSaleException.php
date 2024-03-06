<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CanceledSaleException extends Exception
{
    public function render($request)
    {
        return response()->json(['message' => 'A venda não foi encontrada.'], Response::HTTP_NOT_FOUND);
    }
}