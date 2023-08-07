<?php
declare(strict_types=1);

namespace Tests\Presentations\Api\Auth;

use App\Models\Organization;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class UserLoginRouteTest extends TestCase
{
    /**
     * @var Organization
     */
    protected Organization $organization;

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
        $organization = Organization::first();
        if (! $organization instanceof Organization) {
            $this->markTestSkipped(
                'Event not found'
            );
        }

        $this->organization = $organization;
        $this->url = route('auth.login');
    }

    /**
     * @return void
     */
    public function testRegisteredUserRouteCanLogIn(): void
    {
        $email = $this->organization->getAttribute('email');

        $responseLogin = $this->post(
            $this->url,
            ['email' => $email, 'password' => 'password'],
            ['Accept' => 'application/json']
        );

        $responseLogin->assertStatus(Response::HTTP_OK);
        static::assertJson($responseLogin->content());
        static::assertArrayHasKey('plainTextToken', $responseLogin->json());
    }
}
