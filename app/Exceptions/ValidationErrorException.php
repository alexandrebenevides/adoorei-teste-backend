<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ValidationErrorException extends Exception
{
    public function __construct($message, $data = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    public function render($request)
    {
        return response()->json($this->data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}