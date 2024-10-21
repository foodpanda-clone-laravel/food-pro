<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\RegisterUserRequest;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Services\UserService;
use Faker\Extension\Helper;
use Illuminate\Http\JsonResponse;
use App\Services\AuthServices;
use App\Services\Cart\ShoppingSessionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Help;
use PragmaRX\Google2FAQRCode\Google2FA;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getValidatedData();
        $result = $this->userService->loginUser($credentials);
        if (!$result) {

            return Helpers::sendFailureResponse(401, 'Invalid Credentials');
        }
        else{
            return Helpers::sendSuccessResponse(
                200,
                'Logged in successfully',
                $result,
                ['Authorization' => 'Bearer ' . $result['access_token']]
            );
        }

    }
    public function logout(): JsonResponse
    {
        $result = $this->userService->logoutUser();

        return Helpers::sendSuccessResponse(200,'logged out successfully');
    }


    


    public function loginV2(Request $request)
    {
        $code = $request->input('code'); 
        $credentials = $request->only('email', 'password');
        // Optional 2FA code

        $result = $this->userService->loginWith2FA($credentials, $code);

        if (isset($result['error'])) {
            return Helpers::sendFailureResponse(
                $result['error'] === 'Invalid credentials' ? 401 : 400,
                $result['error']
            );
        }

        if (isset($result['firstLogin']) && $result['firstLogin']) {
            return Helpers::sendSuccessResponse(
                Response::HTTP_OK,
                '2FA enabled. Save your key or scan the QR code.',
                $result
            );
        }

        return Helpers::sendSuccessResponse(200, 'Login successful', $result);
    }

   
}

    
       
    


