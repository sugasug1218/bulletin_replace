<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ApiResponseType extends Enum
{

    /** responseステータス */
    const SUCCESS_RESPONSE = 200;
    const BAD_REQUEST = 400;
    const AUTH_ERROR_RESPONSE = 401;

    /** エラーコードとエラーメッセージ */
    const NO_ERROR = 0;
    const PARAM_ERROR = 2;
    const DB_ERROR = 3;
    const EXISTS_ERROR = 4;
    const UNKNOWN_ERROR = 9;
    
    const ERROR_MESSAGE = [
        self::NO_ERROR => '正常終了',
        self::PARAM_ERROR => 'パラメータエラー',
        self::DB_ERROR => 'データベース関連のエラー',
        self::EXISTS_ERROR => '存在しないid',
        self::UNKNOWN_ERROR => '未定義のエラー'
    ];

    /**
     * Undocumented function
     *
     * @param integer $code
     * @return string
     */
    public static function getErrorMessage(int $code)
    {
        return ApiResponseType::ERROR_MESSAGE[$code];
    }
}
