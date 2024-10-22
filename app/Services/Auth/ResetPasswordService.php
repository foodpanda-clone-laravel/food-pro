<?php

namespace App\Services\Auth;
use App\Helpers\Helpers;
use App\Http\Requests\AuthRequests\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;

use App\Interfaces\ResetPasswordServiceInterface;
use Illuminate\Support\Str;

class ResetPasswordService implements ResetPasswordServiceInterface
{

    public function submitForgotPasswordForm($data){
        $email = $data['email'];
        $status=  Password::sendResetLink(
                ['email'=>$email]
            );
        return $status === Password::RESET_LINK_SENT;
    }
    public function resetPassword($data){
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));
                $user->save();

            }
        );
        return $status === Password::PASSWORD_RESET;

    }
}
