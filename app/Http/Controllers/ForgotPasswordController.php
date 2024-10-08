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
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);

    }
}
