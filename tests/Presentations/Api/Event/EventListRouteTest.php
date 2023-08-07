<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Event;

use Tests\Presentations\AuthorizeApiTestCase;

final class EventListRouteTest extends AuthorizeApiTestCase
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
    public function testEventListRouteReturnedSameDBData(): void
    {
        $response = $this->get($this->url, $this->headers);
        $responseArray = array_map(function (array $item) {
            return ['id' => $item['id']];
        }, $response->json());

        static::assertJson($response->content());
        static::assertEquals($this->organization->events()->get(['id'])->toArray(), $responseArray);
    }
}
