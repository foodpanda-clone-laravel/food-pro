<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'delivery_address',
        'favorites',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
