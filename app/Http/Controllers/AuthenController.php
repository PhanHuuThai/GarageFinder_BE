<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenRequest;
use App\Repositories\UserRepository;
use App\Services\AuthenService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenController extends Controller
{
    protected $authenService;

    /**
     * __construct
     *
     * @param mixed $userService
     */
    public function __construct(AuthenService $authenService)
    {
        $this->authenService = $authenService;
    }

    public function login(AuthenRequest $request)
    {
        $user = $this->authenService->login($request);
        // return $user;
        if ($user["success"]) {
            return response()->json([
                'data' => $user,
                'token' => $user['data']->createToken("API TOKEN")->plainTextToken
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "email or password not exists",
            ], 200);
        }
    }

    public function logout(Request $request)
    {
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

    public function repass(Request $request)
    {
        $user = $this->authenService->repass($request);
        return $this->sendResponse($user);
    }


    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        // Log environment variables to check if they are loaded correctly
        Log::info('GOOGLE_CLIENT_ID: ' . env('GOOGLE_CLIENT_ID'));
        Log::info('GOOGLE_CLIENT_SECRET: ' . env('GOOGLE_CLIENT_SECRET'));
        Log::info('GOOGLE_REDIRECT_URI: ' . env('GOOGLE_REDIRECT_URI'));
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return JsonResponse
     */
    public function handleGoogleCallback(): JsonResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = (new UserRepository)->getUserByEmail($googleUser->getEmail());

            if ($user) {
                // Update Google info
                $user->google_id = $googleUser->getId();
                $user->save();
            } else {
                // Create a new user
                $user = (new UserRepository)->create([
                    'name' => $googleUser->getName(),
                    'username' => $googleUser->getEmail(), // Use email as username
                    'id_provider' => 1,
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'id_role' => 1,
                    'id_ward' => 1,
                ]);
            }

            $loginRequest = new AuthenRequest();
            $loginRequest->merge([
                'email' => $user->email,
                'password' => $user->password, // This won't be used for Google login
            ]);
            $this->login($loginRequest);

            return response()->json([
                'data' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google login error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status' => false,
                'message' => 'Unable to login with Google.',
                'data' =>  $e->getMessage()
            ], 500);
        }
    }

}
