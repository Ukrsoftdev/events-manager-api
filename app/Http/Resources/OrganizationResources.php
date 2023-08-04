<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class OrganizationResources extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'organization_id' => $this->id,
            'organization_name' => $this->name,
            'email' => $this->email,
            'password' => 'password',
            'count_events' => $this->events()->count(),
        ];
    }
}
