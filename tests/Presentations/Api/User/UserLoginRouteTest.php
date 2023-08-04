<?php

namespace Tests\Presentations\Api\User;

use App\Models\Organization;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserLoginRouteTest extends TestCase
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
        $this->organization = Organization::first();
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
