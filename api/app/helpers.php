<?php

use App\Helpers\DisclosureLetter;
use App\Helpers\ResponseStatusCodes;
use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Audit;
use App\Models\FmdqBankAccount;
use App\Models\InvoiceContent;
use App\Models\User;
use Illuminate\Support\Str;
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
            "data" => $data,
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
            "data" => $data,
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
if (!function_exists('applicationType')) {
    function applicationType($application, $withPronoun = false)
    {
        $type = $application->application_type;

        switch ($type) {

            case Application::type['CON']:
                $pronoun = $withPronoun ? 'a' : '';
                $subject = "$pronoun Conversion";
                break;
            case Application::type['ADD']:
                $pronoun = $withPronoun ? 'a' : '';
                $subject = "$pronoun Addition";
                break;
            default:
                $pronoun = $withPronoun ? "an" : "";
                $subject = "$pronoun Application";
                break;
        }

        return $subject;

    }
}

if (!function_exists('getApplicationFieldValue')) {
    function getApplicationFieldValue(User $user, Application $application, $application_field)
    {

        $data = ApplicationField::where('name', $application_field)
            ->join('application_field_uploads', function ($join) use ($application) {
                $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                    ->where('application_field_uploads.application_id', '=', $application->id);
            })
            ->select('application_field_uploads.*')
            ->first();

        $name = $user->first_name . ' ' . $user->last_name;
        $companyName = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        $companyName = $companyName ? $companyName : $name;
        return $companyName;
    }
}

if (!function_exists('getInstitutionFieldValue')) {
    function getInstitutionFieldValue(Application $application, $application_field)
    {

        $data = ApplicationField::where('name', $application_field)
            ->join('application_field_uploads', function ($join) use ($application) {
                $join->on('application_fields.id', '=', 'application_field_uploads.application_field_id')
                    ->where('application_field_uploads.application_id', '=', $application->id);
            })
            ->select('application_field_uploads.*')
            ->first();

        $name = $application->applicant->first_name . ' ' . $application->applicant->last_name;
        $companyName = false;
        if ($data) {
            $companyName = $data->uploaded_field ? $data->uploaded_field : $data->uploaded_file;
        }

        $companyName = $companyName ? $companyName : $name;
        return $companyName;
    }
}

if (!function_exists('disclosureContent')) {
    function disclosureContent($application_uuid)
    {

        $application = Application::where('uuid', $application_uuid)->first();

        return (new DisclosureLetter())->generate($application, true);
    }
}
