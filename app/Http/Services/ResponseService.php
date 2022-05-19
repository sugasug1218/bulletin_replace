<?php

namespace App\Http\Services;

use App\Http\Services\ApiBaseService;
use RuntimeException;

class ResponseService extends ApiBaseService
{
    /**
     * successResponse
     *
     * @param array $data
     * @return json
     */
    public function successResponse(array $data)
    {
        $response = response()->json([
            'status' => self::NO_ERROR,
            'message' => $this->getErrorMessage(self::NO_ERROR),
            'result' => [
                $data
            ]
        ], 200);
        return $response;
    }

    /**
     * パラメータ起因のエラーレスポンス
     *
     * @param RuntimeException $e
     * @return array
     */
    public function badRequestResponse(RuntimeException $e)
    {
        $response = response()->json([
            'status' => $e->getCode(),
            'message' => $e->getMessage(),
            'result' => []
        ], 400);
        return $response;
    }

    /**
     * 認証エラーのレスポンス
     *
     * @param RuntimeException $e
     * @return json
     */
    public function UnauthorizedResponse(RuntimeException $e)
    {
        $response = response()->json([
            'status' => $e->getCode(),
            'message' => $e->getMessage()
        ], 401);
        return $response;
    }

    public function unknownErrorResponse()
    {
        $response = response()->json([
            'status' => self::UNKNOWN_ERROR,
            'message' => $this->getErrorMessage(self::UNKNOWN_ERROR)
        ], 400);
        return $response;
    }
}
