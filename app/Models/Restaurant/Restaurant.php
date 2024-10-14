<?php

namespace App\Models\Restaurant;

use App\Models\Menu\ChoiceGroup;
use App\Models\Menu\Menu;
use App\Models\User\RestaurantOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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
    public function choiceGroups(){
        return $this->hasMany(ChoiceGroup::class);
    }
    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    public function revenue(){
        return $this->hasMany(Revenue::class);
    }
}
