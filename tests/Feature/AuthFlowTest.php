<?php

namespace Tests\Feature;

use App\Eloquent\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @test
     */
    public function a_new_user_has_default_role()
    {
        $user = factory(User::class)->create();
        $this->assertTrue($user->hasRole(config('authflow.users.default_role')));
    }

    /**
     * @test
     */
    public function a_user_can_register_by_email_and_password()
    {
        // Register flow
        $response = $this->post('/register', [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(8, 20),
            'password_confirmation' => $password,
        ]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect('/home');

        // User created correctly
        $user = User::where('email', $email)->first();
        $this->assertSame($user->name, $name);
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /**
     * @test
     */
    public function a_user_can_login_by_email_and_password()
    {
        $password = $this->faker->password(8, 20);
        $user = factory(User::class)->create(['password' => Hash::make($password)]);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }
}
