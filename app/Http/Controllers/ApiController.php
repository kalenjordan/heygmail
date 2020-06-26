<?php

namespace App\Http\Controllers;

use App\Screening;
use App\Thing;
use App\User;
use App\Util;
use Illuminate\Http\Request;
use Webklex\IMAP\Client;
use Webklex\IMAP\Message;

class ApiController extends Controller
{

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function screenMessage(Request $request)
    {
        try {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            return $this->_screenMessage($request);
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
    protected function _screenMessage(Request $request)
    {
        // $messageId = $request->input('message');
        $email = $request->input('email');
        $folder = $request->input('folder');

        $screening = (new Screening())->loadByEmail($email)
        if (!$screening) {
            $screening = (new Screening())->create([
                'Email' => strtolower($email),
            ]);
        }

        $screening->save([
            'Folder' => $folder,
        ]);

        $client = new Client([
            'host'          => Util::imapHost(),
            'port'          => Util::imapPort(),
            'username'      => Util::imapUsername(),
            'password'      => Util::imapPassword(),
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap'
        ]);
        $client->connect();

        $folderObject = $client->getFolder('To Screen');

        $messages = $folderObject->query()->from($email)->get();
        foreach ($messages as $message) {
            /** @var Message $message */
            $message->moveToFolder($folder);
        }

        $message = "Screened $email to $folder";

        return [
            'success' => true,
            'message' => $message,
        ];
    }

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

        (new User())->create([
            'Email'                   => $email,
            'Subscribe to Newsletter' => true,
        ]);

        return [
            'success' => true,
        ];
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function geocode(Request $request)
    {
        try {
            return $this->_geocode($request);
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
    protected function _geocode(Request $request)
    {
        $user = $this->_loadFromApiKey($request);

        $latlon = $request->input('latlon');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latlon&sensor=true&key=" . Util::googleGeocodingApiKey();
        $result = json_decode(file_get_contents($url), true);

        $firstResult = $result['results'][0];
        $city = "";
        foreach ($firstResult['address_components'] as $component) {
            if ($component['types'][0] == 'locality') {
                $city = $component['long_name'];
            } elseif ($component['types'][0] == 'administrative_area_level_1') {
                $state = $component['long_name'];
            } elseif ($component['types'][0] == 'country') {
                $country = $component['long_name'];
            }
        }

        $location = "$city, $state, $country";
        $user->save([
            'Location' => $location,
        ]);

        return ['location' => $location];
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function geocodeDelete(Request $request)
    {
        try {
            return $this->_geocodeDelete($request);
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
    protected function _geocodeDelete(Request $request)
    {
        $user = $this->_loadFromApiKey($request);
        $user->save([
            'Location' => null,
        ]);

        return ['success' => true];
    }

    /**
     * @param Request $request
     *
     * @return User
     * @throws \Exception
     */
    protected function _loadFromApiKey(Request $request)
    {
        $apiKey = $request->input('api_key');
        if (!$apiKey) {
            throw new \Exception("Missing API key");
        }

        $user = (new User())->lookupWithFilter("{Api Key} = '$apiKey'");
        if (!$user) {
            throw new \Exception("Couldn't find user with api key: $apiKey");
        }

        return $user;
    }

    /**
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function things(Request $request)
    {
        $query = $request->input('query');

        $params = array(
            "sort"            => array(array('field' => 'Name', 'direction' => "asc")),
            "maxRecords"      => 10,
            "filterByFormula" => "FIND(LOWER('$query'), LOWER(Name)) > 0",
        );
        $things = (new Thing())->getRecords($params);

        $data = [];
        foreach ($things as $thing) {
            /** @var Thing $thing */
            $data[] = [
                'id'   => $thing->id(),
                'name' => $thing->name(),
            ];
        }

        return $data;
    }
}
