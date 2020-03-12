<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->postJson('/api/signup', $this->getData())
                        ->assertStatus(201)
                        ->assertExactJson([
                            'code' => 201,
                            'message' => 'Signup successful.',
                            'data' => [
                                'id' => 1,
                                'name' => 'John',
                                'email' => 'john@gmail.com',
                            ],
                        ]);

        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => $response['data']['name'],
            'email' => $response['data']['email'],
        ]);
    }

    /** @test */
    public function a_registered_user_should_login()
    {
        $data = $this->getData();

        // Signup
        $this->postJson('/api/signup', $data);

        // Login
        $response = $this->postJson('/api/login', [
            'email' => $data['email'],
            'password' => $data['password'],
            'device_name' => 'Samsung',
        ]);

        $response->assertOk()
                ->assertJson([
                    'code' => 200,
                    'message' => 'Success.',
                ]);

        $token = User::whereEmail($data['email'])->first()->tokens->last()->token;

        // Return token
        $this->assertNotEmpty($response['data']);

        $this->assertEquals($token, hash('sha256', $response['data']));
    }

    /** @test */
    public function it_can_not_login_if_a_user_has_not_been_registered()
    {
        $this->postJson('/api/login', [
            'email' => 'john@gmail.com',
            'password' => 123456,
            'device_name' => 'Samsung',
        ])->assertStatus(422);
    }

    /** @test */
    public function a_registered_user_with_wrong_password_who_can_not_loging()
    {
        $data = $this->getData();

        $this->postJson('/api/signup', $data);

        $this->postJson('/api/login', [
            'email' => $data['email'],
            'password' => 'Wrong Password',
            'device_name' => 'Samsung',
        ])->assertStatus(401);
    }

    protected function getData()
    {
        return [
            'name' => 'John',
            'email' => 'john@gmail.com',
            'password' => 123456,
        ];
    }
}
