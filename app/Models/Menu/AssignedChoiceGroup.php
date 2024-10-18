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
        return $this->belongsTo(ChoiceGroup::class,'choice_group_id','id');
    }

}
