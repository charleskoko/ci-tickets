<?php

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyOwner = User::factory()->create(['type' => User::TYPE_PRO, 'is_admin' => false]);
        $this->normalUser = User::factory()->create(['type' => User::TYPE_NORMAL, 'is_admin' => false]);
        $this->otherProUser = User::factory()->create(['type' => User::TYPE_PRO, 'is_admin' => false]);
        $this->adminUser = User::factory()->create(['type' => User::TYPE_NORMAL, 'is_admin' => true]);
        Company::factory(20)->create();
        $this->companyData = [
            'name' => $this->faker->company,
            'mobile' => $this->faker->phoneNumber,
            'website' => $this->faker->url,
            'localisation' => $this->faker->address,
        ];
    }

    public function testNormalUserCanNotCreateCompany()
    {
        Sanctum::actingAs($this->normalUser);
        $response = $this->post(route('api.v1.company-store'), $this->companyData);
        $response->assertStatus(403);
    }

    public function testAdminOrProUserCanCreateCompany()
    {
        Sanctum::actingAs($this->faker->randomElement([$this->adminUser, $this->otherProUser]));
        $response = $this->post(route('api.v1.company-store'), $this->companyData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', $this->companyData);
    }

    public function testNormalUserCanNotSeeCompany()
    {
        $company = Company::factory()->create();
        Sanctum::actingAs($this->normalUser);
        $response = $this->get(route('api.v1.company-show', $company->id));
        $response->assertStatus(403);
    }

    public function testAdminOrOwnerUserCanSeeCompany()
    {
        $company = Company::factory()->create(['user_id' => $this->companyOwner->id]);
        Sanctum::actingAs($this->faker->randomElement([$this->companyOwner, $this->adminUser]));
        $response = $this->get(route('api.v1.company-show', $company->id));
        $response->assertStatus(200);
    }

    public function testNormalUserCanNotUpdateCompany()
    {
        $company = Company::factory()->create(['user_id' => $this->companyOwner->id]);
        $data = [
            'name' => 'updated company name',
            'mobile' => '+225 0559584746',
        ];
        Sanctum::actingAs($this->normalUser);
        $response = $this->patch(route('api.v1.company-update', $company->id), $data);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('companies', $data);
    }

    public function testAdminOrCompanyOwnerCanUpdateCompany()
    {
        $company = Company::factory()->create(
            $companyData = [
                'user_id' => $this->companyOwner->id,
                'name' => 'before update',
                'mobile' => '12345678'
            ]);
        Sanctum::actingAs($this->faker->randomElement([$this->companyOwner, $this->adminUser]));
        $response = $this->patch(route('api.v1.company-update', $company->id), $updateData = [
            'name' => 'after update',
            'mobile' => '+225 0559584746',
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', $updateData);
        $this->assertDatabaseMissing('companies', $companyData);
    }

    public function testNormalUserCanNotDeleteCompany()
    {
        $company = Company::factory()->create();
        Sanctum::actingAs($this->normalUser);
        $response = $this->delete(route('api.v1.company-destroy', $company->id));
        $response->assertStatus(403);
    }

    public function testAdminOrCompanyOwnerCanDeleteCompany()
    {
        $company = Company::factory()->create(['user_id' => $this->companyOwner->id]);
        Sanctum::actingAs($this->faker->randomElement([$this->companyOwner, $this->adminUser]));
        $response = $this->delete(route('api.v1.company-destroy', $company->id));
        $response->assertStatus(200);
    }
}
