<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function settings(Request $request)
    {
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/auth?redirect=" . $request->path());
        }

        return view('settings', ['user' => $user]);
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function settingsPost(Request $request)
    {
        /** @var User $user */
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/?error=not_logged_in");
        }

        $user->save([
            'Name' => $request->input('name'),
            'About' => $request->input('about'),
        ]);

        return view('settings', ['user' => $user]);
    }
}