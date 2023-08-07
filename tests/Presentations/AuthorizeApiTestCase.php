<?php
declare(strict_types=1);

namespace Tests\Presentations;

use App\Models\Event;
use App\Models\Organization;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AuthorizeApiTestCase extends TestCase
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
        /** @var Factory $factoryEvent */
        $factoryEvent = Event::factory(1);
        $organization = Organization::factory(1)->has($factoryEvent, 'events')->create();

        /** @var Organization $organization */
        $organization = $organization->first();
        $email = $organization->getAttribute('email');
        $url = route('auth.login');

        $this->organization = $organization;

        $responseLogin = $this->post(
            $url,
            ['email' => $email, 'password' => 'password'],
            ['Accept' => 'application/json']
        );

        $this->token = $responseLogin->json('plainTextToken');
        $this->headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token];
    }

    protected function tearDown(): void
    {
        $this->organization->delete();
    }
}
