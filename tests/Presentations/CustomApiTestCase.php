<?php

namespace Tests\Presentations;

use App\Models\Organization;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Tests\TestCase;

class CustomApiTestCase extends TestCase
{
    /**
     * @var Organization
     */
    protected Organization $organization;
    /**
     * @var string
     */
    protected string $token;
    /**
     * @var array
     */
    protected array $headers;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $organization = Organization::has('events', '>=', 2)->first();
        if (is_null($organization)) {
            throw new NotFoundResourceException('Organization not found');
        }

        $this->organization = $organization;
        $email = $this->organization->getAttribute('email');
        $url = route('auth.login');

        $responseLogin = $this->post(
            $url,
            ['email' => $email, 'password' => 'password'],
            ['Accept' => 'application/json']
        );

        $this->token = $responseLogin->json('plainTextToken');
        $this->headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token];
    }
}
