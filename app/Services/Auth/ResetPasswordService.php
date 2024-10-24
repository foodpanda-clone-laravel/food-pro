<?php

namespace App\Services\Auth;
use App\Helpers\Helpers;
use App\Http\Requests\AuthRequests\ForgotPasswordRequest;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;

use App\Interfaces\ResetPasswordServiceInterface;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordService implements ResetPasswordServiceInterface
{

    public function submitForgotPasswordForm($data){

        $status = Password::sendResetLink(
            $data
        );
        return $status === Password::RESET_LINK_SENT
            ? Helpers::sendSuccessResponse(Response::HTTP_OK, 'Success')
            :Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED);

    }
    public function submitResetPasswordForm($data){

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
            ? Helpers::sendSuccessResponse(Response::HTTP_OK, 'password reset successfully')
            : Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED);

    }
}
