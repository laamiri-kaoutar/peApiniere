<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class AuthControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    // public function test_register_a_valid_user(): void
    // {
    //     $userData = [
    //         "name"=>"koko",
    //         "email"=>"koko@gmail.com",
    //         "password"=>"123456789",
    //         "password_confirmation"=>"123456789",
    //         "role_id"=> 2
    //     ];

    //     $response = $this->postJson('/api/register' , $userData);


    //     $response->assertStatus(200);

    //     $this->assertDatabaseHas('users', [
    //         'email' => 'koko@gmail.com'
    //     ]);

    //     $response->assertJsonStructure([
    //         'user' => ['id', 'name', 'email'],
    //         'access_token',
    //         'token_type',
    //         'expires_in'
    //     ]);

    // }

    public function test_register_a_invalid_user() : void
    {
        $userData = [
            "name" => "Kaoutar",
            "email" => "invalid-email", 
            "password" => "password123",
            "password_confirmation" => "password123",
            "role_id" => 1
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_login_a_valid_user():void
    {
        $userData = [
            "email"=>"koko@gmail.com",
            "password"=>"123456789"
        ];

        $response = $this->postJson('/api/login' , $userData);


        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'koko@gmail.com'
        ]);

        $response->assertJsonStructure([
            'user' => ['id', 'name', 'email'],
            'access_token',
            'token_type',
            'expires_in'
        ]);

    }

    public function test_logout_a_user()
    {
        $user = \App\Models\User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->postJson('/api/logout') ; 

        $response->assertStatus(200);

        $response ->assertJson(['message' => 'Successfully logged out']);

    }

}
