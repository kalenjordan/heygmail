<?php

namespace App;

class Util
{
    public static function extractEmail($fullFromLine)
    {
        if (strpos($fullFromLine, '<') === false) {
            return $fullFromLine;
        }

        preg_match('/<(.*)>/', $fullFromLine, $output);
        return $output[1];
    }

    public static function googleAppName()
    {
        return env('GOOGLE_APP_NAME');
    }

    public static function googleClientId()
    {
        return env('GOOGLE_CLIENT_ID');
    }

    public static function googleClientSecret()
    {
        return env('GOOGLE_CLIENT_SECRET');
    }

    public static function googleRedirect()
    {
        return env('GOOGLE_REDIRECT');
    }

    public static function imapHost1()
    {
        return env("IMAP1_HOST");
    }

    public static function imapPort1()
    {
        return env("IMAP1_PORT");
    }

    public static function imapUsername1()
    {
        return env("IMAP1_USERNAME");
    }

    public static function imapPassword1()
    {
        return env("IMAP1_PASSWORD");
    }

    public static function imapHost2()
    {
        return env("IMAP2_HOST");
    }

    public static function imapPort2()
    {
        return env("IMAP2_PORT");
    }

    public static function imapUsername2()
    {
        return env("IMAP2_USERNAME");
    }

    public static function imapPassword2()
    {
        return env("IMAP2_PASSWORD");
    }

    public static function isProduction()
    {
        return env('APP_ENV') == 'production';
    }

    public static function appUrl()
    {
        return env('APP_URL');
    }

    public static function appName()
    {
        return env('APP_NAME');
    }

    public static function svgLogo()
    {
        return env('LOGO_SVG');
    }

    public static function googleGeocodingApiKey()
    {
        return env('GOOGLE_GEOCODING_API');
    }

    /**
     * @param $user User
     *
     * @return bool
     */
    public static function isAdmin($user)
    {
        if (! $user) {
            return false;
        }

        $adminEmails = explode(',', env('ADMIN_EMAILS'));
        return (in_array($user->email(), $adminEmails));
    }

    public static function airtableUrl()
    {
        return "https://airtable.com/" . env('AIRTABLE_BASE_ID');
    }

    public static function algoliaAppId()
    {
        return env('ALGOLIA_APP_ID');
    }

    public static function algoliaPublicKey()
    {
        return env('ALGOLIA_PUBLIC_KEY');
    }

    public static function algoliaPublicKeyForAdmin()
    {
        return env('ALGOLIA_PUBLIC_KEY_ADMIN');
    }

    /**
     * @param $user User
     *
     * @return mixed
     */
    public static function algoliaPublicKeyFor($user = null)
    {
        if (isset($user) && $user && $user->isAdmin()) {
            return self::algoliaPublicKeyForAdmin();
        }

        return env('ALGOLIA_PUBLIC_KEY');
    }

    public static function algoliaPrivateKey()
    {
        return env('ALGOLIA_PRIVATE_KEY');
    }
}
