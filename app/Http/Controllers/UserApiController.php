<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\ResponseService;
use App\Http\Services\UserService;
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
        $param = $this->getRequestParameter($request);
        $result = $this->userService->storeUserService($param);
        return $this->responseService->successResponse($result);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->userService->getUserById($id);
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
        $param = $this->getRequestParameter($request, $id);
        $result = $this->userService->updateUserService($param, $id);
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
        $result = $this->userService->deleteUserService($id);
        return $this->responseService->successResponse($result);
    }
}
