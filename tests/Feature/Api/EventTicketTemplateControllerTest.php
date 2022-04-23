<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Event;
use App\Models\EventTicketTemplate;
use App\Models\EventType;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTicketTemplateControllerTest extends TestCase
{
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

    public function testUserCanCreateEventTicketTemplate()
    {
        $user = User::factory()->create(['type' => User::TYPE_PRO]);
        EventType::factory()->create();
        Company::factory()->create();
        $event = Event::factory()->create();
        $data = [
            'label' => 'VIP',
            'price' => 100000,
        ];
        Sanctum::actingAs($user);
        $response = $this->post(route('api.v1.eventTicketTemplate-store', $event), $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('event_ticket_templates', $data);
    }

    public function testUserCanSeeEventTicketTemplate()
    {
        $user = User::factory()->create(['type' => User::TYPE_PRO]);
        EventType::factory()->create();
        Company::factory()->create();
        $event = Event::factory()->create();
        $eventTicketTemplate = EventTicketTemplate::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get(route('api.v1.eventTicketTemplate-show', $eventTicketTemplate));
        $response->assertStatus(200);
    }

    public function testUserCanUpdateEventTicketTemplate()
    {
        $user = User::factory()->create(['type' => User::TYPE_PRO]);
        EventType::factory()->create();
        Company::factory()->create();
        $event = Event::factory()->create();
        $eventTicketTemplate = EventTicketTemplate::factory()->create([
            'label' => 'VIP - ',
            'price' => 100000,
        ]);
        $data = [
            'label' => 'VIP - 1',
        ];
        Sanctum::actingAs($user);
        $response = $this->patch(route('api.v1.eventTicketTemplate-update', $eventTicketTemplate),$data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('event_ticket_templates',$data);
        $this->assertDatabaseMissing('event_ticket_templates',[
            'label' => 'VIP - ',
            'price' => 100000,
        ]);
    }

    public function testUSerCanDeleteEventTicketTemplate()
    {
        $user = User::factory()->create(['type' => User::TYPE_PRO]);
        EventType::factory()->create();
        Company::factory()->create();
        $event = Event::factory()->create();
        $eventTicketTemplate = EventTicketTemplate::factory()->create([
            'label' => 'VIP - ',
            'price' => 100000,
        ]);
        Sanctum::actingAs($user);
        $response = $this->delete(route('api.v1.eventTicketTemplate-destroy',$eventTicketTemplate));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('event_ticket_templates',[
            'label' => 'VIP - ',
            'price' => 100000,
        ]);
    }
}
