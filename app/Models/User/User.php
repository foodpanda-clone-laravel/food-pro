<?php

namespace App\Models\User;

use App\Models\Cart\ShoppingSession;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;


// Import SoftDeletes
class User extends Authenticatable implements JWTSubject
{
    use HasRoles;

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id');
    }

    public function restaurantOwner()
    {
        return $this->hasOne(RestaurantOwner::class);
    }
    public function shoppingSession(){
        return $this->hasOne(ShoppingSession::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
           'role' => $this->role,
        ];
    }

}
