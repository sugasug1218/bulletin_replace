<?php

namespace App\Http\Services;

use App\Http\Services\ResponseService;
use App\Models\User;
use RuntimeException;
use App\Enums\ApiResponseType;

class UserService extends ResponseService
{
    protected $user;
    protected $responseService;

    public function __construct(
        User $users,
        ResponseService $responseService
    ) {
        $this->users = $users;
        $this->responseService = $responseService;
    }

    public function getUser()
    {
        $users = $this->users->getUserAllByRequest();
        return $users;
    }

    public function getUserById(int $id)
    {
        $data = $this->users->getUserById($id);
        if ($data) {
            return $data;
        }
        throw new RuntimeException($this->getErrorMessage(ApiResponseType::EXISTS_ERROR), ApiResponseType::EXISTS_ERROR);
    }

    public function storeUserService(array $param)
    {
        $res = $this->users->storeUserByRequest($param);
        if (!$res) {
            throw new RuntimeException(ApiResponseType::getErrorMessage(ApiResponseType::PARAM_ERROR), ApiResponseType::PARAM_ERROR);
        }
        return $res;
    }

    /**
     * ユーザー情報の更新
     *
     * @param array $param
     * @param [type] $id
     * @return array
     */
    public function updateUserService(array $param, $id)
    {
        $res = $this->users->updateUserByRequest($param, $id);
        if (!$res) {
            throw new RuntimeException(ApiResponseType::getErrorMessage(ApiResponseType::PARAM_ERROR), ApiResponseType::PARAM_ERROR);
        }

        return $this->getUserById($id); // 更新したデータ返却
    }

    public function deleteUserService($id)
    {
        $result = $this->users->deleteUserByRequest($id);
        
        if ($result) {
            $res['success'] = "ユーザー削除に成功しました";
        } elseif (!$result) {
            throw new RuntimeException($this->getErrorMessage(ApiResponseType::EXISTS_ERROR), ApiResponseType::EXISTS_ERROR);
        }
        return $res;
    }
}
