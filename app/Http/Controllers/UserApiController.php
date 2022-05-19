<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
use RuntimeException;
use Exception;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    protected $userService;
    protected $responseService;

    public function __construct(
        UserService $userService,
        ResponseService $responseService
    ) {
        $this->userService = $userService;
        $this->responseService = $responseService;
    }

    protected function getRequestParameter(Request $request, $id = null)
    {
        $param = $request->only([
            'name', 'email', 'password'
        ]);
        $param['id'] = $id;
        return $param;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->userService->getUser();
        return $this->responseService->successResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $param = $this->getRequestParameter($request);
            $result = $this->userService->storeUserService($param);
        } catch (RuntimeException $e) {
            return $this->responseService->badRequestResponse($e);
        } catch (Exception $e) {
            return $this->responseService->unknownErrorResponse();
        }
        
        return $this->responseService->successResponse($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = $this->userService->getUserById($id);
        } catch (RuntimeException $e) {
            return $this->responseService->badRequestResponse($e);
        } catch (Exception $e) {
            return $this->responseService->unknownErrorResponse();
        }
        return $this->responseService->successResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $param = $this->getRequestParameter($request, $id);
            $result = $this->userService->updateUserService($param, $id);
        } catch (RuntimeException $e) {
            return $this->responseService->badRequestResponse($e);
        } catch (Exception $e) {
            return $this->responseService->unknownErrorResponse();
        }
        return $this->responseService->successResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->userService->deleteUserService($id);
        } catch (RuntimeException $e) {
            return $this->responseService->badRequestResponse($e);
        } catch (Exception $e) {
            return $this->responseService->unknownErrorResponse();
        }
        return $this->responseService->successResponse($result);
    }
}
