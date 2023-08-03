<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplaceEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json(EventResource::collection(Event::all()));
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function show(Event $event): JsonResponse
    {
        return response()->json(new EventResource($event));
    }

    /**
     * @param Event $event
     * @param ReplaceEventRequest $request
     * @return JsonResponse
     */
    public function replace(Event $event, ReplaceEventRequest $request): JsonResponse
    {
        $event->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Event $event
     * @param UpdateEventRequest $request
     * @return JsonResponse
     */
    public function update(Event $event, UpdateEventRequest $request): JsonResponse
    {
        $event->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Event $event
     * @return JsonResponse
     */
    public function delete(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
