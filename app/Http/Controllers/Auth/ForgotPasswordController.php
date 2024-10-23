<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ForgotPasswordRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;

use Symfony\Component\HttpFoundation\Response;


class ForgotPasswordController extends Controller
{
    protected $passwordService;
    public function __construct(ResetPasswordService $service){
        $this->passwordService = $service;
    }
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){
        $this->passwordService->submitResetPasswordForm($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Reset password email sent.');
    }
    public function submitResetPasswordForm(ResetPasswordRequest $request){
            $result = $this->passwordService->submitResetPasswordForm($request);
            if($result){
                Helpers::sendSuccessResponse(Response::HTTP_OK, 'password reset successfully');
            }
            else{
                Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED);
            }
    }
}
