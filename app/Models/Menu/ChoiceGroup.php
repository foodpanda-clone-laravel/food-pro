<?php

namespace App\Models\Menu;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function menuItem(){
        return $this->belongsTo(MenuItem::class);
    }
    public function choices(){
        return $this->hasMany(Choice::class,'choice_group_id','id');
    }
    public function addons(){
        return $this->hasMany(Addon::class,'choice_group_id','id');
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
