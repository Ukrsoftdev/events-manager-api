<?php

namespace Tests\Presentations\Api\Event;

use App\Models\Event;
use App\Models\Scopes\EventsByOrganizationIdScope;
use Tests\Presentations\CustomApiTestCase;

class EventListRouteTest extends CustomApiTestCase
{
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
        $this->url = route('event.list');
    }

    /**
     * @return void
     */
    public function test_successfully(): void
    {
        $response = $this->get($this->url, $this->headers);
        $responseArray = array_map(function (array $item) {
            return ['id' => $item['id']];
        }, $response->json());

        static::assertJson($response->content());
        static::assertEquals(Event::withoutGlobalScope(EventsByOrganizationIdScope::class)->get(['id'])->toArray(), $responseArray);
    }
}
