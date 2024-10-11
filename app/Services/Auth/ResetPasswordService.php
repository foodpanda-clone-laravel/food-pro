<?php

namespace App\Services\Auth;
use Illuminate\Support\Facades\Password;

use App\Interfaces\ResetPasswordServiceInterface;

class ResetPasswordService implements ResetPasswordServiceInterface
{

    public function submitForgotPasswordForm($data){
        $email = $data['email'];
        $status=  Password::sendResetLink(
                ['email'=>$email]
            );
        dd($status);
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

}