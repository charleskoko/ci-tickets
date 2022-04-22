<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $event = $this->resource;
        return [
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
            'site' => $event->site,
            'date' => $event->date,
            'available_places' => $event->available_places,
            'company' => CompanyResource::make($event->company),
            'eventType' => EventTypeResource::make($event->eventType)
        ];
    }
}
