<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'description' => substr($event->description,0,100).'...',
            'site' => $event->site,
            'date' => Carbon::parse($event->date)->toDateString(),
            'available_places' => $event->available_places,
            'company' => CompanyResource::make($event->company),
            'eventType' => $event->eventType->label
        ];
    }
}
