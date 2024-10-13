<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function choiceGroup(){
        return $this->belongsTo(ChoiceGroup::class);
    }
}
