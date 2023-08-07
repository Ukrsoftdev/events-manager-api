<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Organization;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class OrganizationListRouteTest extends TestCase
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
    public function testOrganizationListRouteReturnedSameDBData(): void
    {
        $response = $this->get($this->url);

        $response->assertStatus(Response::HTTP_OK);
        static::assertJson($response->content());
    }
}
