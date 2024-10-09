<?php

namespace App\Http\Controllers;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use App\Services\ResetPasswordService;
use Illuminate\Support\Facades\Password;
use App\Helpers\Helpers;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    private $passwordService;
    public function __construct(ResetPasswordService $service){
        $this->passwordService = $service;
    }
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){
        $validatedData = $request->validated();
        $email = $validatedData['email'];
        // sends a pasword reset link to the provided email
        
        $status = Password::sendResetLink(
           ["email"=>$email]
        );
        return $status === Password::RESET_LINK_SENT
        ? Helpers::sendSuccessResponse(200, 'Success')
        :Helpers::sendFailureResponse(401, 'Invalid email');
    
    }
    public function submitResetPasswordForm(ResetPasswordRequest $request){
        $data = $request->validated();
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