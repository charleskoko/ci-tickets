<?php

namespace Tests\Feature\Api;

use App\Models\EventType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTypeControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        EventType::factory(10)->create();
        $this->eventTypeData = [
            'label' => 'Concert',
            'description' => 'Evenement regourpant dans des personnes dans une salle pour ecouter de la music.',
        ];
        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->noAdminUser = User::factory()->create(['is_admin' => false]);
        $this->eventTypeFormation = EventType::factory()->create([
            'label' => $this->label = $this->faker->word,
            'description' => $this->description = $this->faker->words(100, true)
        ]);
    }

    public function createEventType(): EventType
    {
        return EventType::factory()->create(
            [
                'label' => 'test',
                'description' => 'description'
            ]
        );
    }

    public function testAdminUserCanCreateEventType()
    {
        Sanctum::actingAs($this->adminUser);
        $response = $this->post(route('api.v1.event_type-store'), $this->eventTypeData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('event_types', $this->eventTypeData);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $response->assertJsonCount(1, 'data');
    }

    public function testNotAdminUserCannotCreateEventType()
    {
        $data = [
            'label' => 'Soirée',
            'description' => 'Evenement dans la nuit',
        ];
        Sanctum::actingAs($this->noAdminUser);
        $response = $this->post(route('api.v1.event_type-store'), $data);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('event_types', $data);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $response->assertJsonCount(0, 'data');
    }

    public function testAllUserCanSeeEventTypeList()
    {
        Sanctum::actingAs($this->faker->randomElement([$this->noAdminUser, $this->adminUser]));
        $response = $this->get(route('api.v1.event_type-index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function testAdminUserCanUpdateEventType()
    {
        $data = [
            'label' => 'updated label',
            'description' => 'updated event',
        ];
        Sanctum::actingAs($this->adminUser);
        $response = $this->patch(route('api.v1.event_type-update', $this->eventTypeFormation->id), $data);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('event_types', ['label' => $this->label, 'description' => $this->description]);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        $this->assertDatabaseHas('event_types', $data);
    }

    public function testNotAdminUserCannotUpdateEventType()
    {
        $data = [
            'label' => 'updated label',
            'description' => 'updated event',
        ];
        Sanctum::actingAs($this->noAdminUser);
        $response = $this->patch(route('api.v1.event_type-update', $this->eventTypeFormation->id), $data);
        $response->assertStatus(403);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function testAdminUserCanDeleteEventType()
    {
        $eventType = $this->createEventType();
        Sanctum::actingAs($this->adminUser);
        $response = $this->delete(route('api.v1.event_type-update', $eventType->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('event_types', ['label' => 'test', 'description' => 'description']);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

    public function testNotAdminUserCannotDeleteEventType()
    {
        $eventType = $this->createEventType();
        Sanctum::actingAs($this->noAdminUser);
        $response = $this->delete(route('api.v1.event_type-update', $eventType->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('event_types', ['label' => 'test', 'description' => 'description']);
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }

}
