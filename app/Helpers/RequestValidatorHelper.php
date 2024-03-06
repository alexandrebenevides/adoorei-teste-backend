<?php

namespace App\Helpers;

use App\Exceptions\ValidationErrorException;
use Validator;

class RequestValidatorHelper
{
    public static function make(array $parameters, array $rules)
    {
        $validator = Validator::make($parameters, $rules);
    
        if ($validator->fails()) {
            throw new ValidationErrorException('Erros de validação.', ['errors' => $validator->errors()->all()]);
        }
    }
}