<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_with_a_role()
    {
        $response = $this->post('/register', [
            'username' => 'newstudent',
            'role' => 'Student',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'newstudent',
            'role' => 'Student',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_student_registration_creates_a_linked_student_profile()
    {
        $this->post('/register', [
            'username' => 'newstudentprofile',
            'role' => 'Student',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $user = User::where('username', 'newstudentprofile')->first();

        $this->assertNotNull($user);
        $this->assertNotNull($user->student);
        $this->assertEquals($user->student->student_id, $user->linked_id);
    }
}
