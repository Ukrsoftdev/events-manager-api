<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\CustomApiTestCase;

class EventShowRouteTest extends CustomApiTestCase
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
        $this->event = $this->organization->events()->first();
        $this->url = route('event.show', ['event' => $this->event->id]);
    }

    /**
     * @return void
     */
    public function testEventShowRouteReturnedSameDBData(): void
    {
        $response = $this->get($this->url, $this->headers);
        static::assertJson($response->content());
        static::assertEquals($this->event->getAttributes(), $response->json());
    }
}
