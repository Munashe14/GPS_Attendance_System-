<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::create([
            'username' => 'studentuser',
            'password' => bcrypt('password'),
            'role' => 'Student',
            'status' => 'Active',
        ]);

        $response = $this->post('/login', [
            'username' => 'studentuser',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('student.dashboard'));
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        User::create([
            'username' => 'studentuser',
            'password' => bcrypt('password'),
            'role' => 'Student',
            'status' => 'Active',
        ]);

        $this->post('/login', [
            'username' => 'studentuser',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_dashboard_route_redirects_to_the_authenticated_users_dashboard()
    {
        $user = User::create([
            'username' => 'studentuser2',
            'password' => bcrypt('password'),
            'role' => 'Student',
            'status' => 'Active',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect(route('student.dashboard'));
    }
}
