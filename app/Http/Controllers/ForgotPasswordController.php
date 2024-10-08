<?php

namespace App\Http\Controllers;
use App\Http\Reqeusts\ForgotPasswordRequest;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){
        return response(200);
    }
    public function submitResetPasswordForm(){

    }
}
