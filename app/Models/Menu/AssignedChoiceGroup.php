<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedChoiceGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function choiceGroup(){
        // assigned choice group belongs to choice group
        return $this->belongsTo(ChoiceGroup::class);
    }
    public function menuItem(){
        return $this->belongsTo(MenuItem::class,'menu_item_id','id');
    }

}
