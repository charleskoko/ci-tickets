<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserDemoSeeder::class, EventTypeDemoSeeder::class]);
    }
}
