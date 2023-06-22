<?php

namespace App\Http\Resources;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = null;
    public function toArray(Request $request)
    {
        
         return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // 'department' => $this->department[0]->id,
            'phone_number' => $this->phoneNumber,
             'role' => $this->role[0]->id
            
        ];
    }
    

}
