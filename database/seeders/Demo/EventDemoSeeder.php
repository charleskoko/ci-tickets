<?php

namespace Database\Seeders\Demo;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::factory(100)->create();
    }
}
