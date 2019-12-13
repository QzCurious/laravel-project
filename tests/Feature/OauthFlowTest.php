<?php

namespace Tests\Feature;

use App\Eloquent\Auth\OauthAccount;
use App\Eloquent\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\AbstractUser;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

// https://stackoverflow.com/a/37220779
class OauthFlowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var array
     */
    private $fakeIdToken;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @test
     */
    public function a_user_can_login_by_google_as_oauth_provider()
    {
        // Create OAuth registered user
        $oauthAccount = factory(OauthAccount::class)->create(['provider' => 'google']);
        $this->fakeIdToken = [
            'sub' => $oauthAccount->sub,
            'name' => $oauthAccount->user->name,
            'email' => $oauthAccount->user->email,
            'avatar' => null,  // skip
        ];
        $this->mock_socialite_facade('google');
        $response = $this->get(route('oauth.callback', 'google'));

        $this->assertAuthenticatedAs($oauthAccount->user);
    }

    /**
     * @test
     */
    public function a_user_can_register_by_google_as_oauth_provider()
    {
        // Mock OAuth response
        $this->fakeIdToken = [
            'sub' => $this->faker->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'avatar' => null,  // skip
        ];
        $this->mock_socialite_facade('google');
        $response = $this->get(route('oauth.callback', 'google'));
        $response->assertRedirect(route('home'));

        $user = Auth::user();
        $oauthAccount = $user->oauthAccounts->first();
        $this->assertSame($this->fakeIdToken['name'], $user->name);
        $this->assertSame($this->fakeIdToken['email'], $user->email);
        $this->assertSame($this->fakeIdToken['sub'], $oauthAccount->sub);
    }

    /**
     * @test
     */
    public function a_user_can_be_linked_with_google_account()
    {
        // Create and login user
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // Mock OAuth response
        $this->fakeIdToken = [
            'sub' => $this->faker->uuid,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'avatar' => null,  // skip
        ];
        $this->mock_socialite_facade('google');
        $response = $this->get(route('oauth.callback', 'google'));
        $response->assertRedirect(route('home'));

        // User linked with google OauthAcount
        $oauthAccount = OauthAccount::where([
            'user_id' => $user->id,
            'sub' => $this->fakeIdToken['sub'],
            'provider' => 'google',
        ])->first();
        $this->assertNotNull($oauthAccount);
    }

    protected function mock_socialite_facade(string $provider)
    {
        Socialite::shouldReceive('driver')->with($provider)
            ->andReturn($this->socialite_driver_mockery($provider));
    }

    protected function socialite_driver_mockery(string $driver)
    {
        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')
            ->andReturn($this->socialite_abstract_user_mockery());

        return $provider;
    }

    protected function socialite_abstract_user_mockery()
    {
        $user = Mockery::mock(AbstractUser::class);
        $user->shouldReceive('getId')->andReturn($this->fakeIdToken['sub']);
        $user->shouldReceive('getName')->andReturn($this->fakeIdToken['name']);
        $user->shouldReceive('getEmail')->andReturn($this->fakeIdToken['email']);
        $user->shouldReceive('getAvatar')->andReturn($this->fakeIdToken['avatar']);

        return $user;
    }
}
