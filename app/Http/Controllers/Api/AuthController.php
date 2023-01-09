<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var UserServices
     */
    private $userService;

    public function __construct(UserServices $userServices)
    {
        $this->userService = $userServices;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:15|min:6|confirmed'
        ]);
        $input = $request->all();
        $response = $this->userService->createUser($input);
        return $this->successResponse(
            201,
            'Registered successfully please check you email for account verification.',
            $response
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'otp' => 'required'
        ]);
        $input = $request->all();
        $this->userService->verifyUserOTP($input);
        return $this->successResponse(200,'Your verification has been completed please login to your account');
    }

    /**
     * @param Request $request
     * @return JsonResponse|void
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials  = $request->only(['email','password']);
        if($token = Auth::guard('api')->attempt($credentials)){
            return $this->successResponse(200,'Login successfully.',[
                'token' => $token,
                'type' => 'bearer',
                'expire_in' => Auth::guard('api')->factory()->getTTL() * 60
            ]);
        }
        $this->errorResponse(400,'credentials did not matched.');
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->successResponse(200,'Logout successfully!');
    }
}
