<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName() ?? $googleUser->getNickname(),
                    'password' => bcrypt(Str::random(24)), // random password since OAuth
                ]
            );

            Auth::login($user);

            return redirect('/dashboard'); // or wherever you want to redirect
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Unable to login, try again.');
        }
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();

        $user = User::firstOrCreate([
            'email' => $facebookUser->getEmail(),
        ], [
            'name' => $facebookUser->getName(),
            'password' => bcrypt('123456dummy'),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }


    // Redirect to GitHub
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    // Handle GitHub callback
    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            // Find or create user
            $user = User::updateOrCreate([
                'email' => $githubUser->getEmail(),
            ], [
                'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                'password' => bcrypt(Str::random(24)), // Dummy password
                'github_id' => $githubUser->getId(),
            ]);

            Auth::login($user);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Login failed. Try again.');
        }
    }


    // Redirect to LinkedIn
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    // Handle LinkedIn callback
    public function handleLinkedinCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();

            $user = \App\Models\User::updateOrCreate([
                'email' => $linkedinUser->getEmail(),
            ], [
                'name' => $linkedinUser->getName(),
                'password' => bcrypt(\Illuminate\Support\Str::random(24)),
                'linkedin_id' => $linkedinUser->getId(),
            ]);

            \Illuminate\Support\Facades\Auth::login($user);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('LinkedIn login failed');
        }
    }

    public function redirectToBitbucket()
    {
        return Socialite::driver('bitbucket')->redirect();
    }

    public function handleBitbucketCallback()
    {
        $bitbucketUser = Socialite::driver('bitbucket')->user();

        $user = User::firstOrCreate(
            ['email' => $bitbucketUser->getEmail()],
            [
                'name' => $bitbucketUser->getName() ?? $bitbucketUser->getNickname(),
                'password' => bcrypt('bitbucket_default_password'), // optional placeholder
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

}



