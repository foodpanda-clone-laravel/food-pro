<?php

namespace App\Models\User;

use App\Models\Customer\Favourite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'customer_id', 'id');
    }
}
