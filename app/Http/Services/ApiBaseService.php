<?php

namespace App\Http\Services;

abstract class ApiBaseService
{
    protected const NO_ERROR = 0;
    protected const AUTH_ERROR = 100;
    protected const PARAM_ERROR = 200;
    protected const DB_ERROR = 300;
    protected const EXISTS_ERROR = 400;
    protected const UNKNOWN_ERROR = 900;

    protected const ERROR_MESSAGE = [
    self::NO_ERROR => '正常終了',
    self::AUTH_ERROR => '認証エラー',
    self::PARAM_ERROR => 'パラメータエラー',
    self::DB_ERROR => 'データベース関連のエラー',
    self::EXISTS_ERROR => '存在しないid',
    self::UNKNOWN_ERROR => '未定義のエラー'
    ];

    protected function getErrorMessage(int $code)
    {
        return self::ERROR_MESSAGE[$code];
    }
}
