<?php

namespace App\Http\Resources;

use App\Models\Scopes\EventsByOrganizationId;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResources extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'OrganizationId' => $this->id,
            'OrganizationName' => $this->name,
            'email' => $this->email,
            'password' => 'password',
            'countEvents' => $this->events()->count(),
        ];
    }
}
