<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customerID'=> $this->id,
            'customerName'=> $this->name,
            'customerEmail'=> $this->email,
            'customerPassword'=> $this->password,
            'customerPhoneNumber'=> $this-> phoneNumber

        ];
    }
}
