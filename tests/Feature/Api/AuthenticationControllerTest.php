<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userData = $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'is_admin' => true,
            'type' => $this->faker->randomElement(User::ACCOUNT_TYPES),
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
    }

    public function testUserCanCreateAnAccount()
    {
        unset($this->userData['is_admin']);
        $response = $this->post(route('api.v1.registration'), $this->userData);
        $response->assertStatus(201);
        unset($this->userData['password_confirmation'], $this->userData['password']);
        $this->assertDatabaseHas('users',$this->userData );
    }

    public function testUserCanCreateAdminAccount()
    {
        $response = $this->post(route('api.v1.registration'), $this->userData);
        $response->assertStatus(201);
        unset($this->userData['password_confirmation'], $this->userData['password']);
        $this->assertDatabaseHas('users',$this->userData );
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
