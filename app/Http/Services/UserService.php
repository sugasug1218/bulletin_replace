<?php

namespace App\Http\Services;

use App\Http\Services\ApiBaseService;
use App\Http\Services\ResponseService;
use App\Models\User;
use Exception;
use PDOException;
use RuntimeException;
use Illuminate\Support\Facades\DB;

class UserService extends ApiBaseService
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
        throw new RuntimeException($this->getErrorMessage(self::PARAM_ERROR), self::PARAM_ERROR);
    }

    public function storeUserService(array $param)
    {
        try {
            DB::beginTransaction();
            $res = $this->users->storeUserByRequest($param);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::UNKNOWN_ERROR), self::UNKNOWN_ERROR);
        } catch (PDOException $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::DB_ERROR), self::DB_ERROR);
        }

        if (!$res) {
            $res = [];
            $res['error'] = 'ユーザーの追加に失敗しました';
        }
        return $res;
    }

    public function updateUserService(array $param, $id)
    {
        try {
            DB::beginTransaction();
            $res = $this->users->updateUserByRequest($param, $id);
            if (!$res) {
                throw new RuntimeException($this->getErrorMessage(self::EXISTS_ERROR), self::EXISTS_ERROR);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::UNKNOWN_ERROR), self::UNKNOWN_ERROR);
        } catch (PDOException $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::DB_ERROR), self::DB_ERROR);
        }

        return $this->getUserById($id); // 更新したデータ返却
    }

    public function deleteUserService($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->users->deleteUserByRequest($id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::UNKNOWN_ERROR), self::UNKNOWN_ERROR);
        } catch (PDOException $e) {
            DB::rollback();
            throw new RuntimeException($this->getErrorMessage(self::DB_ERROR), self::DB_ERROR);
        }
        
        if ($result) {
            $res['success'] = "ユーザー削除に成功しました";
        } elseif (!$result) {
            throw new RuntimeException($this->getErrorMessage(self::EXISTS_ERROR), self::EXISTS_ERROR);
        }
        return $res;
    }
}
