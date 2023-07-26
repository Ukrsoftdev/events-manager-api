<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_title' => $this->event_title,
            'event_start_date' => $this->event_start_date->toDateTimeString(),
            'event_end_date' => $this->event_end_date->toDateTimeString(),
            'organization_id' => $this->organization_id,
        ];
    }
}
