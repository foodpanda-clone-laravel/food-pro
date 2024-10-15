<?php

namespace App\Services\Cart;

use App\Interfaces\ShoppingSessionServiceInterface;
use App\Models\ShoppingSession;

class ShoppingSessionService implements ShoppingSessionServiceInterface
{
    public function getShoppingSession($user){
        $session = ShoppingSession::query()->where('created_at','>',now()->addHours(24))->first();
        if(!$session){
            $session = ShoppingSession::create([
                'user_id' => $user->id,
            ]);
        }
        return $session;
    }
}
