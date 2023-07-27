<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        /** @var Factory $factoryEvent */
        $factoryEvent = Event::factory(15);
         Organization::factory(10)->has($factoryEvent, 'events')->create();
    }
}
