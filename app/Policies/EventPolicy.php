<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Auth\Access\Response;

final class EventPolicy
{
    /**
     * @param Event $event
     * @param Organization $organization
     * @return Response
     */
    public function manage(Organization $organization, Event $event): Response
    {
        return $organization->getAttribute('id') === $event->getAttribute('organization_id')
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
