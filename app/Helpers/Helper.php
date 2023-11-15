<?php

namespace App\Helpers;

use App\UserMeta;

class Helper
{

    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function clean(string $string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = str_replace('_', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = strtolower($string); // Convert to lowercase

        return $string;
    }

    public static function totalAdminFreeSubscribed()
    {
        return UserMeta::where([
            ['meta_key', '=', '_admin_free_subscription_days'],
            ['meta_value', '>', 0],
        ])->count();
    }
}
