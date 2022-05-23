<?php

namespace App\Http\Services;

use App\Enums\ApiResponseType;
use RuntimeException;

class ResponseService
{
    protected function getErrorMessage(int $code)
    {
        return ApiResponseType::ERROR_MESSAGE[$code];
    }

    /**
     * successResponse
     *
     * @param array $data
     * @return json
     */
    public function successResponse(array $data)
    {
        return response()->json([
            'status' => ApiResponseType::NO_ERROR,
            'message' => $this->getErrorMessage(ApiResponseType::NO_ERROR),
            'result' => [
                $data
            ]
        ], ApiResponseType::SUCCESS_RESPONSE);
    }

    public function runtimeExceptionResponse(RuntimeException $e)
    {
        return response()->json([
            'status' => $e->getCode(),
            'message' => $e->getMessage()
        ], ApiResponseType::BAD_REQUEST);
    }


    public function pdoExceptionResponse()
    {
        return response()->json([
            'status' => ApiResponseType::DB_ERROR,
            'message' => $this->getErrorMessage(ApiResponseType::DB_ERROR)
        ], ApiResponseType::BAD_REQUEST);
    }

    /**
     * 未定義のエラー
     *
     * @return void
     */
    public function unknownErrorResponse()
    {
        return response()->json([
            'status' => ApiResponseType::UNKNOWN_ERROR,
            'message' => $this->getErrorMessage(ApiResponseType::UNKNOWN_ERROR)
        ], ApiResponseType::BAD_REQUEST);
    }
}
