<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnapprovedUser extends Model
{
    use HasFactory;
    
    public function department(){
        return $this->belongsTo(Department::class,"department_id");
    }
    public function role(){
        return $this->belongsTo(Role::class,"type");
    }
}
