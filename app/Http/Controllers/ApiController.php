<?php

namespace App\Http\Controllers;

use App\Airtable;
use App\User;
use App\Util;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function newsletterSubscribe(Request $request)
    {
        try {
            return $this->_newsletterSubscribe($request);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    protected function _newsletterSubscribe(Request $request)
    {
        $email = $request->input('email');

        $user = (new User())->create([
            'Email'                   => $email,
            'Subscribe to Newsletter' => true,
        ]);

        return [
            'success' => true,
        ];
    }
}