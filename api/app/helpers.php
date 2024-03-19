<?php

use App\Helpers\ResponseStatusCodes;
use App\Models\Audit;
use App\Models\FmdqBankAccount;
use Illuminate\Support\Str;
use App\Models\InvoiceContent;
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

if (!function_exists('passwordReset')) {
    /**
     * The actual auth service provider
     */
    function passwordReset(): JWTGuard
    {
        /**@var JWTGuard */
        $auth = auth('jwt');

        $auth->Manager()->getJWTProvider()->setSecret(config('jwt.reset_secret'));

        return $auth;
    }
}

if (!function_exists('successResponse')) {
    function successResponse($message = "Successful.", $data = [])
    {
        return response()->json([
            "status" => true,
            "statusCode" => ResponseStatusCodes::OK,
            "message" => $message,
            "data" => $data
        ], Response::HTTP_OK);
    }
}

if (!function_exists('errorResponse')) {
    function errorResponse(int $statusCode = ResponseStatusCodes::BAD_REQUEST, string $message = "An error occurred.", $data = [], $code = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            "status" => false,
            "statusCode" => $statusCode,
            "message" => $message,
            "data" => $data
        ], $code);
    }
}

if (!function_exists('logAction')) {
    function logAction($email, $action, $description, $ipAddress = null)
    {
        Audit::create([
            'user' => $email,
            'action_performed' => $action,
            'description' => $description,
            'ip_address' => $ipAddress,
        ]);
    }
}


if (!function_exists('prettifyJson')) {
    function prettifyJson(array $data)
    {

        // Format JSON for better readability
        $formattedJson = json_encode($data, JSON_PRETTY_PRINT);

        // Remove curly braces
        $formattedJson = str_replace(['{', '}'], '', $formattedJson);

        return nl2br($formattedJson);
    }
}

if (!function_exists('formatDate')) {
    function formatDate($inputDate)
    {
        if (!$inputDate) {
            return '';
        }

        try {
            $dateTime = new DateTime($inputDate);
            return $dateTime->format('M. j, Y');
        } catch (\Throwable $th) {
            return $inputDate;
        }
    }
}

if (!function_exists('fmdqAccountDetails')) {
    function fmdqAccountDetails()
    {
        return FmdqBankAccount::all();
    }
}

if (!function_exists('invoiceChildren')) {
    function invoiceChildren($parent_id)
    {
        $a = InvoiceContent::where("parent_id", $parent_id)->get();
        logger($a);

        return $a;
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($amount)
    {
        return number_format($amount, 2);
    }
}

if (!function_exists('generateReference')) {
    function generateReference()
    {
        $dateTime = now();
        $uniqueId = Str::random(8); // Using Laravel's Str::random for simplicity
        $paymentReference = $dateTime->format('YmdHis') . $uniqueId;

        return $paymentReference;
    }
}

