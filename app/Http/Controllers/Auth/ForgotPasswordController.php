<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ForgotPasswordRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use App\Services\Auth\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    protected $passwordService;
    public function __construct(ResetPasswordService $service){
        $this->passwordService = $service;
    }
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){
        $data = $request->getValidatedData();
        $status = Password::sendResetLink(
           $data
        );
        return $status === Password::RESET_LINK_SENT
        ? Helpers::sendSuccessResponse(200, 'Success')
        :Helpers::sendFailureResponse(401, 'Invalid email');

    }
    public function submitResetPasswordForm(ResetPasswordRequest $request){
        $data = $request->getValidatedData();
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? Helpers::sendSuccessResponse(200, 'password reset successfully')
                    : Helpers::sendFailureResponse(401, 'Could not reset password');

    }
}
