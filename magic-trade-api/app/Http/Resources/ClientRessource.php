<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class ClientRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=> $this->name,
            'last_name'=> $this->last_name,
            'email'=> $this->email,
            'pseudo'=>$this->pseudo,
            'contry'=> $this->contry,
            'city'=> $this->city,
            'street'=> $this->street,
            'postal_code'=> $this->postal_code,
            'phone'=> $this->phone,
            'description'=> $this->description,
            'user_id'=>(int)$this->user_id,
            'user'=> new UserResource($this->user)
        ];
    }
}
