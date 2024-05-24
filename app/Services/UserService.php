<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Http\Requests\User\UserRequest;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        try {
            $users = $this->userRepository->all();
            return $this->successResult($users, "Sucessfully fetched users");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function register($userRequest) 
    {
        try {
            $users = $this->userRepository->storeUser($userRequest);
            return $this->successResult($users, "Sucessfully fetched users");
        } catch (\Exception $e) {
            \Log::info("Register user error: Code:" . $e->getCode(). "  Message: " .$e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }
}