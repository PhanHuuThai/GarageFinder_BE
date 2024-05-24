<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;

class UserController extends Controller
{
    protected $userService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all() {
        $users = $this->userService->all();
        return $this->sendResponse($users);
    }

    public function register(UserRequest $userRequest)
    {
        $user = $this->userService->register($userRequest);
        return $this->sendResponse($user);
    }

}
