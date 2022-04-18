<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Userresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->resource;
        return [
            'id' => $user->id,
            'name' => $user->name,
            'type' => $user->type,
            'email' => $user->email,
        ];
    }
}
