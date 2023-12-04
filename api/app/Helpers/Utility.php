<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Utility
{
    public static function arrayKeysToCamelCase($array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $key = Str::camel($key);
            if (is_array($value)) {
                $value = self::arrayKeysToCamelCase($value);
            }
            $result[$key] = $value;
        }
        return $result;

    }
    public static function getPagination($query): array
    {
        $page = abs($query['page']) ?: 1;
        $limit = abs($query['count']) ?: 10;
        $skip = ($page - 1) * $limit;

        return [
            'skip' => $skip,
            'limit' => $limit,
        ];
    }
    public static function takeUptoThreeDecimal($number): float
    {
        return (float) number_format((float) $number, 3, '.', '');
    }


    public static function generatePassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$&()_';
        $password = '';

        // Loop to randomly select characters from the $characters string
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
}
