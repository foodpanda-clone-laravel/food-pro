<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Relationships
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
