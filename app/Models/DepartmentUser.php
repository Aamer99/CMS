<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;
    public $timestamp = false; 


    public function department(){
        return $this->hasMany(Department::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
