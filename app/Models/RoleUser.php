<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    public $timestamps = false; 


    public function role()
    {
        return $this->hasMany(Role::class,"id");
    }
    public function user()
    {
        return $this->hasMany(User::class,"id");
    }

}
