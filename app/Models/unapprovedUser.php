<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unapprovedUser extends Model
{
    use HasFactory;
    public function manager(){
        return $this->belongsTo(User::class);
    }
}
