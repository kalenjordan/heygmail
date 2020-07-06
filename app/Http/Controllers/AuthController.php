<?php

namespace App\Http\Controllers;

use Algolia\AlgoliaSearch\SearchClient;
use App\Date;
use App\User;
use App\Util;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function auth(Request $request)
    {
        if ($request->input('redirect')) {
            if (strpos($request->input('redirect'), ".")) {
                throw new \Exception("Bad redirect format");
            }
            $request->session()->put('redirect', $request->input('redirect'));
        }

        return Socialite::driver('google')
            ->with([
                "access_type" => "offline",
                "prompt"      => "consent select_account"
            ])
            ->scopes([
                \Google_Service_Gmail::GMAIL_SETTINGS_BASIC,
                \Google_Service_Gmail::GMAIL_MODIFY,
            ])
            ->redirect();
    }

    public function logout(Request $request)
    {
        $request->session()->remove('user');
        return redirect('/');
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $socialiteUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        $email = isset($socialiteUser->email) ? $socialiteUser->email : null;
        $name = isset($socialiteUser->name) ? $socialiteUser->name : null;
        $user = (new User())->lookupWithFilter("Email = '$email'");

        if (!$user) {
            $user = (new User)->create([
                'Name'   => $name,
                'Email'  => $email,
                'Avatar' => [
                    [
                        'url' => isset($socialiteUser->avatar) ? $socialiteUser->avatar : null,
                    ]
                ],
            ]);
        }

        $user->save([
            'Google Access Token' => $socialiteUser->token,
            'Google Refresh Token' => $socialiteUser->refreshToken,
        ]);

        $request->session()->put('user', $user);

        if ($request->session()->get('redirect')) {
            return redirect($request->session()->get('redirect'));
        }

        return redirect('/');
    }
}
