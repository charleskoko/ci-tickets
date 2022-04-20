<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)

    {
        $company = $this->resource;
        return [
            'id' => $company->id,
            'name' => $company->name,
            'website' => $company->website,
            'localisation' => $company->localisation,
        ];
    }
}
