<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         Organization::factory(10)->has(Event::factory()->count(15), 'events')->create();
    }
}
