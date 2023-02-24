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
        return [
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "role" => $this->whenLoaded("roles", function () {
                return $this->roles[0]->name;
            }),
            'token' => $this->when(isset($this->token), function () {
                return $this->token;
            }),
        ];
    }
}
