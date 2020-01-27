<?php

namespace Tests\Feature\Admin;

use App\Eloquent\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var User
     */
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = factory(User::class)->states(config('authflow.users.admin_role'))->create();
    }

    /**
     * @test
     */
    public function a_user_can_be_created()
    {
        $formData = [
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password(8, 20),
            'password_confirmation' => $password,
        ];

        // Redirect to login for guest
        $response = $this->post(route('admin.users.store'), $formData);
        $response->assertRedirect(route('login'));

        // 403 for users who is not an admin_role
        $this->actingAs(factory(User::class)->create());
        $response = $this->post(route('admin.users.store'), $formData);
        $response->assertStatus(403);

        // admin_role
        $this->actingAs($this->admin);
        $response = $this->post(route('admin.users.store'), $formData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('admin.users.index'));

        // User created correctlly
        $user = User::where('email', $email)->first();
        $this->assertTrue(Hash::check($password, $user->password));
        $this->assertTrue($user->hasRole(config('authflow.users.default_role')));
    }

    /**
     * @test
     */
    public function a_user_can_be_updated()
    {
        $formData = [
            'name' => $name = $this->faker->name,
            'phone' => $phone = '0999999999',
            'email' => $email = $this->faker->email,
            'birthday' => $birthday = $this->faker->date,
            'gender' => $gender = random_int(1, 2),
            'password' => $password = $this->faker->password(8, 20),
            'password_confirmation' => $password,
        ];
        $existingUser = factory(User::class)->create();

        // Redirect to login for guest
        $response = $this->put(route('admin.users.update', $existingUser), $formData);
        $response->assertRedirect(route('login'));

        // 403 for users who is not an admin_role
        $this->actingAs(factory(User::class)->create());
        $response = $this->put(route('admin.users.update', $existingUser), $formData);
        $response->assertStatus(403);

        // admin_role
        $this->actingAs($this->admin);
        $response = $this->put(route('admin.users.update', $existingUser), $formData);
        $response->assertRedirect(route('admin.users.edit', $existingUser));

        // User updated correctlly
        $user = User::where([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'birthday' => $birthday,
            'gender' => $gender,
        ])->first();
        $this->assertTrue(Hash::check($password, $user->password));
    }

    /**
     * @test
     *
     * When a user is deleted, its assets should be deleted as well.
     * Assets: roles, permissions
     */
    public function a_user_can_be_deleted()
    {
        $existingUser = factory(User::class)->create();

        // Redirect to login for guest
        $response = $this->delete(route('admin.users.destroy', $existingUser));
        $response->assertRedirect(route('login'));

        // 403 for users who is not an admin_role
        $this->actingAs(factory(User::class)->create());
        $response = $this->delete(route('admin.users.destroy', $existingUser));
        $response->assertStatus(403);

        // admin_role
        $this->actingAs($this->admin);
        $response = $this->delete(route('admin.users.destroy', $existingUser));
        $response->assertRedirect(route('admin.users.index'));
        $this->assertEquals($existingUser->roles()->count(), 0);
        $this->assertEmpty($existingUser->permissions()->count(), 0);
        $this->assertNull($existingUser->fresh());
    }
}
