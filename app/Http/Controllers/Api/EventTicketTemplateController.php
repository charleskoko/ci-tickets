<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventTicketTemplatePostRequest;
use App\Http\Resources\EventTicketTemplateResource;
use App\Models\Event;
use App\Models\EventTicketTemplate;
use App\Traits\ApiResponse;

class EventTicketTemplateController extends Controller
{
    use ApiResponse;

    public function index(Event $event)
    {
        return $this->success(['eventTicketTemplates' => EventTicketTemplateResource::collection($event->eventTicketTemplates)], 'successfully loaded', 200);
    }


    public function store(EventTicketTemplatePostRequest $request, Event $event)
    {
        $validatedData = $request->validated();

        $eventTicketTemplate = new EventTicketTemplate($validatedData);
        $eventTicketTemplate->event()->associate($event);
        $eventTicketTemplate->save();

        return $this->success(['eventTicketTemplate' => EventTicketTemplateResource::make($eventTicketTemplate)], 'successfully created', 201);
    }


    public function show(EventTicketTemplate $eventTicketTemplate)
    {
        return $this->success(['eventTicketTemplate' => EventTicketTemplateResource::make($eventTicketTemplate->refresh())], 'successfully loaded', 200);
    }


    public function update(EventTicketTemplatePostRequest $request, EventTicketTemplate $eventTicketTemplate)
    {
        $validatedData = $request->validated();
        $eventTicketTemplate->update($validatedData);

        return $this->success(['eventTicketTemplate' => EventTicketTemplateResource::make($eventTicketTemplate->refresh())], 'successfully loaded', 200);
    }


    public function destroy(EventTicketTemplate $eventTicketTemplate)
    {
        $eventTicketTemplate->delete();

        return $this->success([], 'successfully deleted', 200);
    }
}
