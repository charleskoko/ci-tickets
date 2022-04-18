<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventTypePostRequest;
use App\Http\Resources\EventTypeResource;
use App\Models\EventType;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class EventTypeController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(['event_types' => EventTypeResource::collection(EventType::all())], 'Successfully ', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param EventTypePostRequest $request
     * @return JsonResponse
     */
    public function store(EventTypePostRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $eventType = EventType::create($validatedData);

        return $this->success(['event_type' => EventTypeResource::make($eventType)], 'Successfully created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param EventType $eventType
     * @return JsonResponse
     */
    public function show(EventType $eventType): JsonResponse
    {
        return $this->success(['event_type' => EventTypeResource::make($eventType->refresh())], 'Successfully loaded', 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EventTypePostRequest $request
     * @param EventType $eventType
     * @return JsonResponse
     */
    public function update(EventTypePostRequest $request, EventType $eventType): JsonResponse
    {
        $validatedData = $request->validated();
        $eventType->update($validatedData);

        return $this->success(['event_type' => EventTypeResource::make($eventType->refresh())], 'Successfully updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EventType $eventType
     * @return JsonResponse
     */
    public function destroy(EventType $eventType): JsonResponse
    {
        $eventType->delete();
        return $this->success([], 'Successfully deleted', 200);
    }
}
