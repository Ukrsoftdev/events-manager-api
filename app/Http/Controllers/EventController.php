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
    public function list(Event $event): JsonResponse
    {
        return response()->json(EventResource::collection($event->byAuthOrganization()->get()));
    }

    public function show(Event $event): JsonResponse
    {
        return response()->json(new EventResource($event));
    }

    public function replace(Event $event, ReplaceEventRequest $request): JsonResponse
    {
        $event->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function update(Event $event, UpdateEventRequest $request): JsonResponse
    {
        $event->update($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function delete(Event $event): JsonResponse
    {
        $event->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
