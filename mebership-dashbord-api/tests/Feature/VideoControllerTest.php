<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Video;

class VideoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_video()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->postJson('/videos', [
                             'title' => $this->faker->sentence,
                             'url' => $this->faker->url,
                             'group_id' => null,
                             'user_id' => $user->id,
                             'is_private' => false,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'title', 'url', 'group_id', 'user_id', 'is_private']);
    }

    public function test_retrieve_videos()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        Video::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->getJson('/videos');

        $response->assertStatus(200)
                 ->assertJsonStructure([['id', 'title', 'url', 'group_id', 'user_id', 'is_private']]);
    }

    public function test_update_video()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->putJson("/videos/{$video->id}", ['title' => 'Updated Video Title']);

        $response->assertStatus(200)
                 ->assertJson(['id' => $video->id, 'title' => 'Updated Video Title']);
    }

    public function test_delete_video()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
                         ->deleteJson("/videos/{$video->id}");

        $response->assertStatus(204);
    }
}
