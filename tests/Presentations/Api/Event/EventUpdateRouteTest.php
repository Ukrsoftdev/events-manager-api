<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\AuthorizeApiTestCase;

final class EventUpdateRouteTest extends AuthorizeApiTestCase
{
    /**
     * @var Event
     */
    private Event $event;

    /**
     * @var string
     */
    private string $url;

    /**
     * @var string
     */
    private string $newEventEndDate;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $event = $this->organization->events()->first();
        if (! $event instanceof Event) {
            $this->markTestSkipped(
                'Event not found'
            );
        }

        $id = $event->getAttribute('id');
        $this->event = $event;
        $eventSstartDate = $event->getAttribute('event_start_date');


        $this->url = route('event.update', ['event' => $id]);
        $this->newEventEndDate = $eventSstartDate->add('3 hours 15 minutes')->toDateTimeString();
    }

    /**
     * @return void
     */
    public function testEventUpdateRouteCanUpdate(): void
    {
        $this->patch($this->url, [
            'event_end_date' => $this->newEventEndDate
        ], $this->headers);

        /** @var Event $updatedEvent */
        $updatedEvent = $this->event->fresh();

        $eventEndDate = $updatedEvent->getAttribute('event_end_date');
        static::assertEquals($eventEndDate->toDateTimeString(), $this->newEventEndDate);
    }
}
