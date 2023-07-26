<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\CustomApiTestCase;

class EventDeleteRouteTest extends CustomApiTestCase
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
        $this->url = route('event.delete', ['event' => $this->event->id]);
    }

    /**
     * @return void
     */
    public function test_successfully(): void
    {
        $this->delete($this->url, [],$this->headers);
        static::assertEquals( null, Event::find($this->event->id));
    }
}
