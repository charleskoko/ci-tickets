<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testUserCanCreateAnAccount()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'type' => $this->faker->randomElement(User::ACCOUNT_TYPES),
            'password' => $password = $this->faker->password,
            'password_confirmation' => $password,
        ];
        $response = $this->post(route('api.v1.registration'), $userData);
        $response->assertStatus(201);
        unset($userData['password_confirmation'], $userData['password']);
        $this->assertDatabaseHas('users',$userData );
    }

    public function testUserCanLogin()
    {
        $response = $this->post(route('api.v1.login'),['email' => $this->user->email,'password' => '12345678']);
        $response->assertStatus(201);
        $this->assertDatabaseHas('personal_access_tokens',['tokenable_id' => $this->user->id]);
    }

    public function testUserCanLogout()
    {
        Sanctum::actingAs($this->user);
        $response = $this->post(route('api.v1.logout'));
        $response->assertStatus(200);
    }
}
