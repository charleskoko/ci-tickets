<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    use WithFaker;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'mobile' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'localisation' => $this->faker->address,
            'user_id' => User::factory()->create(['is_admin' => false])->id,
            'is_active' => $this->faker->randomElement([true, false])
        ];
    }
}
