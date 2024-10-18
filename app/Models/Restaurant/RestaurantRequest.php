<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class RestaurantRequest extends Model
{
    use HasFactory;


    protected $guarded=[];
    public function __construct(){
        return $this->logo_path = rtrim(env('APP_URL'), '/') . '/' . ltrim(Storage::url($this->logo_path), '/');
    }
}
