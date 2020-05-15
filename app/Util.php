<?php

namespace App;

class Util
{
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
}