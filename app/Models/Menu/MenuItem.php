<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->hasMany(AssignedChoiceGroup::class, 'menu_item_id', 'id');
    }
}
