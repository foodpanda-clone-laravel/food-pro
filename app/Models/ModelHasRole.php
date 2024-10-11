<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
class ModelHasRole extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';
    public function roleName(){
        return $this->belongsTo(Role::class, 'role_id');
    }
}
