<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\CustomApiTestCase;

class EventUpdateRouteTest extends CustomApiTestCase
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
        $this->event = $this->organization->events()->first();
        $this->url = route('event.update', ['event' => $this->event->id]);
        $this->newEventEndDate = $this->event->getAttribute('event_start_date')->add('3 hours 15 minutes')->toDateTimeString();
    }

    /**
     * @return void
     */
    public function testEventUpdateRouteCanUpdate(): void
    {
        $this->patch($this->url, [
            'event_end_date' => $this->newEventEndDate
        ], $this->headers);

        $updatedEvent = $this->event->fresh();
        static::assertEquals($updatedEvent->getAttribute('event_end_date')->toDateTimeString(), $this->newEventEndDate);
    }
}
