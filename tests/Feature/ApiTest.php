<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRegistration()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }

    public function testUserLogin()
    {
        $user = User::factory()->create(['email' => 'johndoe@example.com']);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    public function testUnauthorizedAccess()
    {
        $response = $this->postJson('/api/tweets', [
            'content' => 'Hello world!',
        ]);

        $response->assertStatus(401);
    }

    public function testTweetCreation()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        // Generate a dummy image attachment
        $attachment = UploadedFile::fake()->image('attachment.jpg', 400, 300);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/tweets', [
            'content' => 'Hello world!',
            'attachment' => $attachment,
        ]);

        $response->assertStatus(201);
    }

    public function testTweetUpdate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        // Generate a dummy image attachment
        $attachment = UploadedFile::fake()->image('attachment.jpg', 400, 300);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/tweets/' . $tweet->id, [
            'content' => 'Updated tweet',
            'attachment' => $attachment,
        ]);

        $response->assertStatus(200);
    }

    public function testTweetDeletion()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $tweet = Tweet::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/tweets/' . $tweet->id);

        $response->assertStatus(200);
    }

    public function testFollowUser()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $userToFollow = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/users/' . $userToFollow->id . '/follow');

        $response->assertStatus(200);
    }

    public function testGetFollowedTweets()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/tweets/followed');

        $response->assertStatus(200);
    }

    public function testGetSuggestedUsers()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users/suggested');

        $response->assertStatus(200);
    }
}
