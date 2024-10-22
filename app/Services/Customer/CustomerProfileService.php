<?php

namespace App\Services\Customer;

use App\Interfaces\CustomerProfileServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerProfileService implements CustomerProfileServiceInterface
{
    public function changePassword($data){
        try{
            $user = Auth::user();
            if (Hash::check($data->old_password, $user->password)) {
                $user->password = bcrypt($data->new_password);
                $user->save();
                return true;
            }
            else{
                return false;
            }
        }
        catch(\Exception $e){
            dd($e);
        }
    }
}
