<?php

namespace Tests\Presentations;

use App\Models\Organization;
use Tests\TestCase;

class CustomApiTestCase extends TestCase
{
    /**
     * @var Organization
     */
    protected Organization $organization;
    /**
     * @var string|mixed
     */
    protected string $token;
    /**
     * @var array|string[]
     */
    protected array $headers;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->organization = Organization::first();

        $responseLogin = $this->post(
            '/api/user/login',
            ['email' => $this->organization->getAttribute('email'), 'password' => 'password'],
            ['Accept' => 'application/json']
        );
        $this->token = $responseLogin->json('plainTextToken');
        $this->headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token];
    }
}
