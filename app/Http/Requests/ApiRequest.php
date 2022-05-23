<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Enums\ApiResponseType;

abstract class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => ApiResponseType::PARAM_ERROR,
            'message' => ApiResponseType::getErrorMessage(ApiResponseType::PARAM_ERROR),
            'result' => $validator->errors()->toArray(),
        ];
        throw new HttpResponseException(response()->json($data, ApiResponseType::BAD_REQUEST));
    }
}
