<?php

namespace App;

class GoogleClient
{
    public static function client($accessToken)
    {
        $client = new \Google_Client();
        $client->setApplicationName(Util::googleAppName());
        $client->setScopes(\Google_Service_Gmail::GMAIL_SETTINGS_BASIC);

        $config = [
            'web' => [
                'client_id'                   => Util::googleClientId(),
                "auth_uri"                    => "https://accounts.google.com/o/oauth2/auth",
                "token_uri"                   => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_secret"               => Util::googleClientSecret(),
                "redirect_uris"               => [Util::googleRedirect()]
            ]
        ];

        $client->setAuthConfig($config);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $client->setAccessToken($accessToken);

        return $client;
    }
}
