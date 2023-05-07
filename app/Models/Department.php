<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function users(){
        return $this->hasMany(User::class,"department_id");
    } 
    public function unapprovedUsers(){
        return $this->hasMany(UnapprovedUser::class,"department_id");
    } 
    
    public function requests(){
        return $this->hasMany(Request::class,"department_id");
    }
    
}
