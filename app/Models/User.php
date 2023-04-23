<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



   
    function department(){
        return $this->belongsTo(Department::class,"department_id");
    }
    function otp(){
        return $this->has(Otp::class,"user_id");
    }
    public function sender(){
        return $this->has(User::class,"sender_id");
    }
    public function received(){
        return $this->has(User::class,"received_id");
    }
     public function requests(){
        return $this->hasMany(Request::class,"owner_id");
    }
}
