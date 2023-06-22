<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   
    public function toArray(Request $request)
    {

        
        return [
            "name"=> $this-> name,
            "users"=> UserResource::collection($this->users)
            // "name"=> $this->users->id,
            // "department"=> $this->name,
            // "phoneNumber"=> $this->users->phoneNumber,
        ];
    }

 
}
