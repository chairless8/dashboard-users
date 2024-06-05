<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Group;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_group()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/groups', [
                             'name' => $this->faker->company,
                             'owner_id' => $user->id,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'name', 'owner_id']);
    }

    public function test_retrieve_groups()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        Group::factory()->count(3)->create(['owner_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/groups');

        $response->assertStatus(200)
                 ->assertJsonStructure([['id', 'name', 'owner_id']]);
    }

    public function test_update_group()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $group = Group::factory()->create(['owner_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->putJson("/groups/{$group->id}", ['name' => 'Updated Group Name']);

        $response->assertStatus(200)
                 ->assertJson(['id' => $group->id, 'name' => 'Updated Group Name']);
    }

    public function test_delete_group()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $group = Group::factory()->create(['owner_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->deleteJson("/groups/{$group->id}");

        $response->assertStatus(204);
    }
}
