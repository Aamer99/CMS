<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;

    public function sender(){
        return $this->belongsTo(User::class,"sender_id");
    }
    public function received(){
        return $this->belongsTo(User::class,"received_id");
    }
}
