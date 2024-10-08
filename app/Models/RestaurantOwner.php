<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cnic',
        'bank_name',
        'iban',
        'account_owner_title',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
