<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
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
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $event = $this->organization->events()->first();

        if (! $event instanceof Event) {
            throw new NotFoundResourceException();
        }
        $this->event = $event;

        $id = $this->event->id;
        $this->url = route('event.delete', ['event' => $id]);
    }

    /**
     * @return void
     */
    public function testEventDeleteRouteCanDelete(): void
    {
        $this->delete($this->url, [],$this->headers);
        static::assertEquals( null, Event::find($this->event->id));
    }
}
