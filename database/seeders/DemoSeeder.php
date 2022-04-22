<?php

namespace Database\Seeders;

use Database\Seeders\Demo\CompanyDemoSeeder;
use Database\Seeders\Demo\EventDemoSeeder;
use Database\Seeders\Demo\EventTypeDemoSeeder;
use Database\Seeders\Demo\UserDemoSeeder;
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
        $this->call([UserDemoSeeder::class, EventTypeDemoSeeder::class, CompanyDemoSeeder::class, EventDemoSeeder::class]);
    }
}
