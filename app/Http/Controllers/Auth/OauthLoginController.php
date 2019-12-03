<?php

namespace App\Http\Controllers\Auth;

use App\Auth\OauthAccounts;
use App\Http\Controllers\Controller;
use App\User;
use Laravel\Socialite\Facades\Socialite;

class OauthLoginController extends Controller
{
    /**
     * Redirect user to OAuth login provider
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * OAuth callback with access token
     */
    public function handleProviderCallback(string $provider)
    {
        dd($userInfo = Socialite::driver($provider)->user());
    }
}
