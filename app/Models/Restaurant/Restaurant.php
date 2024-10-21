<?php

namespace App\Models\Restaurant;

use App\Models\Cart\CartItem;
use App\Models\Menu\ChoiceGroup;
use App\Models\Menu\Menu;
use App\Models\Menu\Deal\Deal;
use App\Models\Orders\Order;
use App\Models\User\RestaurantOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
