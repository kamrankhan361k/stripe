<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
class SocialAuthController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // Handle GitHub callback
    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->loginOrRegisterUser($user, 'github');
        return redirect()->route('dashboard'); // Adjust this route as needed
    }

    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->loginOrRegisterUser($user, 'google');
        return redirect()->route('dashboard'); // Adjust this route as needed
    }

    // Common function for handling OAuth users
    protected function loginOrRegisterUser($oauthUser, $provider)
    {
        // Find the user or create a new one
        $user = User::firstOrCreate(
            ['email' => $oauthUser->getEmail()],
            [
                'name' => $oauthUser->getName() ?? $oauthUser->getNickname(),
                'password' => Hash::make(Str::random(24)), // Password is randomly generated
                'provider' => $provider,
                'provider_id' => $oauthUser->getId(),
                'avatar' => $oauthUser->getAvatar(),
            ]
        );

        // Log the user in
        Auth::login($user);
    }
}
