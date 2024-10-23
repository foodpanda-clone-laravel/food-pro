<?php

namespace App\Models\Menu;

use App\Models\Cart\CartItem;
use App\Models\ChoiceGroup\AssignedChoiceGroup;
use App\Models\ChoiceGroup\ChoiceGroup;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MenuItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // Relationships
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function choiceGroups(){
        return $this->hasMany(ChoiceGroup::class);
    }
    public function AssignedChoiceGroups(){
        return $this->hasMany(AssignedChoiceGroup::class);
    }
    public function cartItem()
    {
        return $this->belongsTo(CartItem::class);
    }
    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(env('APP_URL'), '/') . '/' . ltrim(Storage::url($this->attributes['image_path']), '/')
        );
    }
}
