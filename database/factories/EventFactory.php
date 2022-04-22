<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\EventType;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    use WithFaker;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition()
    {
        return [
            'name' => $this->faker->domainName,
            'description' => $this->faker->words(200, true),
            'site' => $this->faker->locale,
            'date' => $this->faker->dateTimeBetween(Carbon::now(), Carbon::now()->addDays(30)),
            'available_places' => random_int(100, 4000),
            'event_type_id' => EventType::factory()->create()->id,
            'company_id' => Company::factory()->create()->id
        ];
    }
}
