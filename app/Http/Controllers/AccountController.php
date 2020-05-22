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

        $user = (new User())->load($user->id());

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

        $data = [
            'Name'  => $request->input('name'),
            'About' => $request->input('about'),
        ];

        if ($request->input('favorite_things')) {
            $thingsTheyUseIds = explode(',', $request->input('favorite_things'));
            $thingsTheyUseIds = $this->_saveFavoriteThings($thingsTheyUseIds);
            $data['Favorite Things'] = $thingsTheyUseIds;
        } else {
            $data['Favorite Things'] = [];
        }

        $user->save($data);

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
            'Price'       => (float) $request->input('price'),
            'User'        => [$user->id()],
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

        $data = [
            'Name'        => $request->input('name'),
            'Description' => $request->input('description'),
            'Price'       => (float) $request->input('price'),
        ];

        $thing->save($data);

        return redirect($thing->editUrl() . '?success=Saved');
    }

    /**
     * @param User $user
     * @param      $thingsTheyUseIds
     *
     * @return mixed
     * @throws \Exception
     */
    protected function _saveFavoriteThings($thingIds)
    {
        for ($i = 0; $i < count($thingIds); $i++) {
            $thingId = $thingIds[$i];
            if (substr($thingId, 0, 4) == 'new_') {
                $newThingName = substr($thingId, 4);
                $thingTheyUse = (new Thing())->create(['Name' => $newThingName]);
                $thingIds[$i] = $thingTheyUse->id();
            }
        }

        return $thingIds;
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