<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_only_see_own_companies()
{
    $user = User::factory()->create();
    $company = Company::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user)
        ->get('/companies')
        ->assertSee($company->name);
}

public function test_user_cannot_see_other_users_companies()
{
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $otherCompany = Company::factory()->create(['user_id' => $otherUser->id]);

    $this->actingAs($user)
         ->get('/companies')
         ->assertDontSee($otherCompany->name);
}

}
