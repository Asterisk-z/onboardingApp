<?php

use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('loginAuth')) {
    /**
     * The actual auth service provider
     */
    function loginAuth(): JWTGuard
    {
        /**@var JWTGuard */
        $auth = auth('jwt');

        $auth->Manager()->getJWTProvider()->setSecret(config('jwt.secret'));

        return $auth;
    }
}

if (!function_exists('successResponse')) {
    function successResponse($message = "Successful.", $data = []){
        return response()->json([
            "status" => true,
            "statusCode" => "00",
            "message" => $message,
            "data" => $data
        ], Response::HTTP_OK);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse($statusCode = "99", $message = "An unknown error occured.", $data = [], $code = Response::HTTP_UNPROCESSABLE_ENTITY){
        return response()->json([
            "status" => false,
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $code);
    }
}
