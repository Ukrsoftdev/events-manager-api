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
        $this->organization = Organization::has('events', '>=', 2)->first();

        if (!$this->organization) {
            throw new NotFoundResourceException('Organization not found');
        }

        $responseLogin = $this->post(
            '/api/user/login',
            ['email' => $this->organization->getAttribute('email'), 'password' => 'password'],
            ['Accept' => 'application/json']
        );
        $this->token = $responseLogin->json('plainTextToken');
        $this->headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token];
    }
}
