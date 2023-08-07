<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use Tests\Presentations\AuthorizeApiTestCase;

final class EventShowRouteTest extends AuthorizeApiTestCase
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
            $this->markTestSkipped(
                'Event not found'
            );
        }

        $id = $event->getAttribute('id');
        $this->event = $event;
        $this->url = route('event.show', ['event' => $id]);
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
