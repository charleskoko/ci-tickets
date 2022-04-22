<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Event;
use App\Models\EventType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyOwner = User::factory()->create(['name' => 'owner company', 'type' => User::TYPE_PRO, 'is_admin' => false]);
        $this->normalUser = User::factory()->create(['type' => User::TYPE_NORMAL, 'is_admin' => false]);
        $this->otherProUser = User::factory()->create(['type' => User::TYPE_PRO, 'is_admin' => false]);
        $this->adminUser = User::factory()->create(['type' => User::TYPE_NORMAL, 'is_admin' => true]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testUserCanSeeAllEvent()
    {
        EventType::factory(10)->create();
        Event::factory(10)->create(['company_id' => Company::factory()->create()->id]);
        Sanctum::actingAs($this->normalUser);
        $response = $this->get(route('api.v1.event-index'));
        $response->assertStatus(200);
        $this->assertDatabaseCount('events', 10);
    }

    public function testUserCanCreateEvent()
    {
        EventType::factory(10)->create();
        $user = $this->faker->randomElement([$this->companyOwner, $this->adminUser]);
        $company = Company::factory()->create(['is_active' => true]);
        $user->company()->associate($company);
        $eventType = Event::factory()->create();
        $data = [
            'name' => 'Test',
            'description' => 'Test description',
            'site' => 'Palais de la culture',
            'date' => Carbon::now(),
            'available_places' => 12,
            'event_type_id' => $eventType->id,
        ];
        Sanctum::actingAs($user);
        $response = $this->post(route('api.v1.event-store'), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('events', $data);
    }

    public function testUserCanUpdateEvent()
    {
        EventType::factory(10)->create();
        $company = Company::factory()->create(['is_active' => true]);
        $this->companyOwner->company()->associate($company);
        $event = Event::factory()->create(['company_id' => $company->id]);
        $eventType = Event::factory()->create();
        $data = [
            'name' => 'after update',
            'description' => 'update description test',
            'site' => 'Palais de la culture',
            'date' => Carbon::now(),
            'available_places' => 12,
            'event_type_id' => $eventType->id,
        ];
        Sanctum::actingAs($this->companyOwner);
        $response = $this->patch(route('api.v1.event-update', $event), $data);
        $response->assertStatus(200);
    }

    public function testUserCanDeleteEvent()
    {
        EventType::factory(10)->create();
        $company = Company::factory()->create(['is_active' => true]);
        $this->companyOwner->company()->associate($company);
        Sanctum::actingAs($this->companyOwner);
        $event = Event::factory()->create();
        $response = $this->delete(route('api.v1.event-destroy', $event));
        $response->assertStatus(200);

    }

}
