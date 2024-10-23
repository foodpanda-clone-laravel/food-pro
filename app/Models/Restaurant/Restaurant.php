<?php

namespace App\Models\Restaurant;

use App\Models\Cart\CartItem;
use App\Models\ChoiceGroup\ChoiceGroup;
use App\Models\Menu\Deal\Deal;
use App\Models\Menu\Menu;
use App\Models\Orders\Order;
use App\Models\Rating\Rating;
use App\Models\User\RestaurantOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Restaurant extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    // Relationships
    public function restaurantOwner()
    {
        return $this->belongsTo(RestaurantOwner::class, 'owner_id');
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'restaurant_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'restaurant_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
    public function choiceGroups()
    {
        return $this->hasMany(ChoiceGroup::class);
    }


    public function revenue()
    {

        return $this->hasMany(RevenueReport::class);
    }
    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }
    protected function logoPath(): Attribute
    {
        return Attribute::make(
            get: fn () => rtrim(env('APP_URL'), '/') . '/' . ltrim(Storage::url('logos/' .$this->attributes['logo_path']), '/')
        );
    }
    protected function openingTime(): Attribute
    {
        return Attribute::make(
            get: fn () => \Carbon\Carbon::createFromFormat('H:i:s', $this->attributes['opening_time'])->format('h:i A')
        );
    }

    // Accessor for closing time in 12-hour format
    protected function closingTime(): Attribute
    {
        return Attribute::make(
            get: fn () => \Carbon\Carbon::createFromFormat('H:i:s', $this->attributes['closing_time'])->format('h:i A')
        );
    }
}
