<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventPostRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return EventResource::collection(Event::paginate(10));
    }


    public function store(EventPostRequest $request)
    {
        $validatedData = $request->validated();
        $event = Auth::user()->company->events()->create($validatedData);

        return $this->success(['event' => EventResource::make($event)], 'successfully created', 201);
    }

    public function show(Event $event)
    {
        return $this->success(['event' => EventResource::make($event)], 'successfully loaded', 200);
    }


    public function update(EventPostRequest $request, Event $event)
    {
        $validatedData = $request->validated();
        $event->update($validatedData);

        return $this->success(['event' => EventResource::make($event->refresh())],'successfully updated',200);
    }


    public function destroy(Event $event)
    {
        $event->delete();

        return $this->success([],'successfully deleted',200);
    }
}
