<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate(): void {
        $user = $this->createUser();

        $this->post('/login', [
            'email' => $user->email,
            'password' => config('app.master_password'),
            'remember_me' => false,
        ]);      

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_credentials(): void {
        $user = $this->createUser();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'incorrect'
        ]);

        $this->assertGuest();

        $this->post('/login', [
            'email' => 'incorrect@domain.com',
            'password' => config('app.master_password')
        ]);

        $this->assertGuest();
    }

    private function createUser() {
        $user = User::factory()->create();
        $user->profile()->create();
        $user->privacy()->create();
        return $user;
    }
}
