<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\AuthorizeApiTestCase;

final class EventReplaceRouteTest extends AuthorizeApiTestCase
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
        $this->url = route('event.replace', ['event' => $id]);
        $this->newEventEndDate = $event->getAttribute('event_start_date')->add('2 hours 30 minutes')->toDateTimeString();
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

        /** @var Event $updatedEvent */
        $updatedEvent = $this->event->fresh();
        static::assertEquals($updatedEvent->getAttribute('event_end_date')->toDateTimeString(), $this->newEventEndDate);
    }
}
