<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'branch_id',
        'branches',
        'address',
        'postal_code',
        'city',
        'opening_time',
        'closing_time',
        'cuisine',
        'logo_path',
        'business_type',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(RestaurantOwner::class, 'owner_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
