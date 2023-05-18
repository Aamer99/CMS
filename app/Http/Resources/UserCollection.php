<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
      
        return [
         
                $this->collection->map(function($data,$index) {
                    return [
                        'id'=> $index,
                        'name'=> $data->name,
                        'email'=> $data->email,
                        'phone_number' => $data->phone_number,
                        'department' => $data->department_id
                        
                    ];
                })
            
        ];
    }
}
