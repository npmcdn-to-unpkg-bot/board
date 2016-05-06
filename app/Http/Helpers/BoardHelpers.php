<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;

trait BoardHelpers
{
    /**
     * @param $names
     * @param Request $request
     * @return array
     */
    public static function parseRequest($names, Request $request)
    {
        $data = [];
        foreach ($names as $name) {
            $value = $request->input($name);
            if ($name != 'image' && $value != null) {
                $data[$name] = $value;
            } elseif ($name == 'image') {
                if (self::checkImage($value)) {
                    $data[$name] = $value;
                }
            }
        }
        return $data;
    }

    /**
     * @param $image
     * @return bool
     */
    public static function checkImage($image)
    {
        return ( strlen(strstr($image,"base64")) > 0) ? true: false;
    }
}