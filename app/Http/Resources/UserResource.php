<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//
        // Uncomment the line below if you want to include all default attributes of the User model
        // return parent::toArray($request);

        // Customize the response array with specific attributes
        return [
            'id' => $this->id,                     // User ID
            'name' => $this->name,                 // User name
            'email' => $this->email,               // User email
            'role' => $this->roles()->pluck('name')->implode(', '),  // User roles as a comma-separated string
        ];
    }
}
