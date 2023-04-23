<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    function owner(){
        return $this->belongsTo(Otp::class,"owner_id");
    }
    function department(){
        return $this->belongsTo(Department::class,"department_id");
    }
}
