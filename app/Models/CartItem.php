<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'menu_item_id',
        'quantity',
    ];

    // Relationships
    public function shoppingSession()
    {
        return $this->belongsTo(ShoppingSession::class, 'session_id');
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
