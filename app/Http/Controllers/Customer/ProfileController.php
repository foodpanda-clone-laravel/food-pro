<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\ChangePasswordRequest;
use App\Services\Customer\CustomerProfileService;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    protected $profileService;
    public function __construct(CustomerProfileService $profileService){
        $this->profileService=$profileService;
    }
    public function changePassword(ChangePasswordRequest $request){
        $result = $this->profileService->changePassword($request);
        if(!$result){
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'invalid old password');

        }
        else{
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'changed password successfully');
        }
        }


}
