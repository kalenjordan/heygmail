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

}