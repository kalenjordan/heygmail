<?php

namespace App\Http\Controllers;

use App\Thing;
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

        return view('account.settings', [
            'error'   => $request->input('error'),
            'success' => $request->input('success'),
            'user'    => $user
        ]);
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
            'Name'  => $request->input('name'),
            'About' => $request->input('about'),
        ]);

        return redirect('/account/settings?success=Saved');
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingList(Request $request)
    {
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/auth?redirect=" . $request->path());
        }

        $params = array(
            "filterByFormula" => "{User ID} = '{$user->id()}'",
            "sort"            => [['field' => 'Created', 'direction' => "desc"]],
        );

        $things = (new Thing())->getRecords($params);

        return view('account.thing-list', [
            'error'   => $request->input('error'),
            'success' => $request->input('success'),
            'user'    => $user,
            'things'  => $things,
        ]);
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingNew(Request $request)
    {
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/auth?redirect=" . $request->path());
        }

        return view('account.thing-new', [
            'error'   => $request->input('error'),
            'success' => $request->input('success'),
            'user'    => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingNewPost(Request $request)
    {
        /** @var User $user */
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/?error=not_logged_in");
        }

        $thing = (new Thing())->create([
            'Name'        => $request->input('name'),
            'Description' => $request->input('description'),
            'Price'       => (float)$request->input('price'),
        ]);

        return redirect('/account/things?success=Created ' . $thing->name());
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingEdit(Request $request, $thingId)
    {
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/auth?redirect=" . $request->path());
        }

        $thing = (new Thing())->load($thingId);
        if (!$thing) {
            throw new \Exception("Couldn't load thing: $thingId");
        }

        return view('account.thing-edit', [
            'error'   => $request->input('error'),
            'success' => $request->input('success'),
            'user'    => $user,
            'thing'   => $thing,
        ]);
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingEditPost(Request $request, $thingId)
    {
        /** @var User $user */
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/?error=not_logged_in");
        }

        $thing = (new Thing())->load($thingId);
        if (!$thing) {
            throw new \Exception("Couldn't load thing: $thingId");
        }

        $thing->save([
            'Name'        => $request->input('name'),
            'Description' => $request->input('description'),
            'Price'       => (float)$request->input('price'),
        ]);

        return redirect($thing->editUrl() . '?success=Saved');
    }

    /**
     * @param Request $request
     * @param         $friendId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function thingDelete(Request $request, $thingId)
    {
        /** @var User $user */
        $user = $request->session()->get('user');
        if (!$user) {
            return redirect("/?error=not_logged_in");
        }

        $thing = (new Thing())->load($thingId);
        if (!$thing) {
            throw new \Exception("Couldn't load thing: $thingId");
        }

        $deletedName = $thing->name();
        $thing->delete();

        return redirect("/account/things/?success=Deleted $deletedName");
    }
}