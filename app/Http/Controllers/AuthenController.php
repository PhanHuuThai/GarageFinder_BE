<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenRequest;
use App\Services\AuthenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    protected $authenService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(AuthenService $authenService)
    {
        $this->authenService = $authenService;
    }

    public function login(AuthenRequest $request) {
        $user = $this->authenService->login($request);
        // return $user;    
        if($user["success"]) {
            return response()->json([
                'status' => true,
                'message' => 'Loggin success',
                'token' => $user['data']->createToken("API TOKEN")->plainTextToken
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "email or password not exists",
            ], 200);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Logout success',
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function repass(Request $request) {
        $user = $this->authenService->repass($request);
        return $this->sendResponse($user);
    }
}
