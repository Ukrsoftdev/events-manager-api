<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\CustomApiTestCase;

class EventReplaceRouteTest extends CustomApiTestCase
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
        $this->url = route('event.replace', ['event' => $this->event->id]);
        $this->newEventEndDate = $this->event->getAttribute('event_start_date')->add('2 hours 30 minutes')->toDateTimeString();
    }

    /**
     * @return void
     */
    public function testEventReplaceRouteCanReplace(): void
    {
        $this->put($this->url, [
            'event_title' => $this->event->getAttribute('event_title'),
            'event_start_date' => $this->event->getAttribute('event_start_date'),
            'event_end_date' => $this->newEventEndDate
        ], $this->headers);

        $updatedEvent = $this->event->fresh();
        static::assertEquals($updatedEvent->getAttribute('event_end_date')->toDateTimeString(), $this->newEventEndDate);
    }
}
