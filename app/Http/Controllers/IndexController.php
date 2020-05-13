<?php

namespace App\Http\Controllers;

use App\User;
use App\Util;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function welcome(Request $request)
    {
        $user = $request->session()->get('user');

        return view('welcome', [
            'error'          => $request->input('error'),
            'success'        => $request->input('success'),
            'user'           => $user,
        ]);
    }
}