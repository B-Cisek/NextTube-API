<?php

namespace Modules\Auth\Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\Models\Admin;
use Modules\Auth\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_users_can_authenticate_using_the_login_endpoint(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertNoContent();
    }

    #[Test]
    public function it_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    #[Test]
    public function it_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertNoContent();
    }

    #[Test]
    public function it_new_users_can_register(): void
    {
        $response = $this->post('/signup', [
            'username' => 'TestUser123',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertCreated();
        $response->assertExactJson([
            'user' => [
                'id' => $response->json('user.id'),
                'username' => $response->json('user.username'),
                'email' => $response->json('user.email'),
                'createdAt' => $response->json('user.createdAt'),
                'isEmailVerified' => $response->json('user.isEmailVerified'),
            ],
        ]);
    }

    #[Test]
    public function it_admin_can_authenticate_using_the_login_endpoint(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('admin');
        $response->assertNoContent();
    }

    #[Test]
    public function it_admin_can_logout(): void
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'admin')->post('/admin/logout');

        $this->assertGuest('admin');
        $response->assertNoContent();
    }
}
