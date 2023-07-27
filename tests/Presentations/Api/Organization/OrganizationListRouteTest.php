<?php

namespace Tests\Presentations\Api\Organization;

use Tests\TestCase;

class OrganizationListRouteTest extends TestCase
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
        $this->url = route('organization.list');
    }

    /**
     * @return void
     */
    public function test_successfully(): void
    {
        $response = $this->get($this->url);

        $response->assertStatus(200);
        static::assertJson($response->content());
    }
}
