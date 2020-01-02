<?php

namespace Tests\Feature;

use App\Eloquent\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @test
     */
    public function unauthenticated_users_cant_access_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function not_authorized_users_cant_access_admin_panel()
    {
        // User without any role
        $default_user = factory(User::class)->states(config('authflow.users.default_role'))->create();
        $this->actingAs($default_user);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_users_can_access_admin_panel()
    {
        // User with any role
        $admin = factory(User::class)->states(config('authflow.users.admin_role'))->create();
        $this->actingAs($admin);
        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
    }
}
