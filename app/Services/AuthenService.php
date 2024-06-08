<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {
        try {

            $user = $this->userRepository->getUserByEmail($request->email);



            if($user && Hash::check($request->password, $user->password)) {
                return  $this->successResult($user, "Sucessfully login");
            }
            return $this->errorResult('email or password not exists');
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function repass($request)
    {
        try {
            $user = $this->userRepository->find(auth()->user()->id);
            $user->password = Hash::make($request->password);

            $user = $this->userRepository->updateUser($user);
            return $this->successResult($user, "Sucessfully reset password");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }
}
