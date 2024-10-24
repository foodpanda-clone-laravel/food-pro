<?php

namespace App\Models\User;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantOwner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function restaurant(){
        return $this->hasOne(Restaurant::class, 'owner_id');
    }
}
