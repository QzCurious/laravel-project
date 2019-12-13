<?php

namespace App\Http\Controllers\Auth;

use App\Eloquent\Auth\OauthAccount;
use App\Eloquent\Auth\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $userInfo = Socialite::driver($provider)->user();
        $oauthAccount = OauthAccount::firstOrNew([
            'provider' => $provider,
            'sub' => $userInfo->getId(),
        ]);
        $currentUser = Auth::user();

        // Login by OAuth
        if ($currentUser === null && $oauthAccount->user_id !== null) {
            $user = User::firstOrCreate(
                ['id' => $oauthAccount->user_id],
                [
                    'name' => $userInfo->getName(),
                    'email' => $userInfo->getEmail(),
                    'avatar' => $userInfo->getAvatar(),
                ]
            );
            Auth::login($user);
        }

        // Create an account by OAuth
        if ($currentUser === null && $oauthAccount->user_id === null) {
            $newUser = User::create([
                'name' => $userInfo->getName(),
                'email' => $userInfo->getEmail(),
                'avatar' => $userInfo->getAvatar(),
            ]);
            $newUser->oauthAccounts()->save($oauthAccount);
            Auth::login($newUser);
        }

        // User had logged in, then link it with OAuth
        if ($currentUser && $oauthAccount->user_id === null) {
            $currentUser->oauthAccounts()->save($oauthAccount);
        }

        return redirect()->intended('home');
    }
}
