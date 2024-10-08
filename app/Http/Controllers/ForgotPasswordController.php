<?php

namespace App\Http\Controllers;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use App\Services\ResetPasswordService;
class ForgotPasswordController extends Controller
{
    private $passwordService;
    public function __construct(ResetPasswordService $service){
        $this->passwordService = $service;
    }
    public function submitForgotPasswordForm(ForgotPasswordRequest $request){

        return $this->passwordService->submitForgotPasswordForm($request->validated());
    }
    public function submitResetPasswordForm(){

    }
}
