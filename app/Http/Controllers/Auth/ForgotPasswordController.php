<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ForgotPasswordRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


class ForgotPasswordController extends Controller
{
    protected $passwordService;
    public function __construct(ResetPasswordService $service){
        $this->passwordService = $service;
    }
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){

        $status = Password::sendResetLink(
           $request
        );
        return $status === Password::RESET_LINK_SENT
        ? Helpers::sendSuccessResponse(Response::HTTP_OK, 'Success')
        :Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED, 'Invalid email');

    }
    public function submitResetPasswordForm(ResetPasswordRequest $request){

        $status = Password::reset(
            $request,
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? Helpers::sendSuccessResponse(Response::HTTP_OK, 'password reset successfully')
                    : Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED, 'Could not reset password');

    }
}
