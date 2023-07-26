<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $event_start_date = fake()->dateTimeBetween('+0 days', '+1 years');
        $start_date_clone = clone $event_start_date;
        $event_end_date = fake()->dateTimeBetween($event_start_date, $start_date_clone->modify('+12 hours'));

        return [
            'event_title' => fake()->sentence(),
            'event_start_date' => $event_start_date,
            'event_end_date' => $event_end_date,
            'organization_id' => Organization::factory(),
        ];
    }
}
