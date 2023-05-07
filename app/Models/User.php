<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "user";


   
   public function department(){
        return $this->belongsTo(Department::class,"department_id");
    }
    public function role(){
        return $this->belongsTo(Role::class,"type");
    }
    public function otp(){
        return $this->hasOne(Otp::class,"user_id");
    }
    public function otp_token(){
        return $this->hasOne(OtpToken::class,"user_id");
    }
    public function file(){
        return $this->has(File::class,"request_id");
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
