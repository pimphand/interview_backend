<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'dob' => $this->dob,
            'city' => $this->city,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'id' => $this->id,
        ];
    }
}
