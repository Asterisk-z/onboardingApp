<?php
namespace App\Helpers;

use App\Mail\NotificationMail;
use App\Models\Application;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public static function checkPasswordExpiry(User $user) : bool
    {
        $password = $user->passwords()->orderByDesc('id')->first();

        if(! $password)
            return true;

        if(Carbon::parse($password->created_at)->addMonths(config('app.password_expiry')) <= Carbon::now())
            return false;

        return true;
    }

    public static function checkPasswordPolicy($user, $password)
    {
        $passwords = $user->passwords()->latest()->take(config('app.unique_password'))->pluck('password');

        foreach($passwords as $old_password){
            if(Hash::check($password, $old_password))
                return false;
        }

        return true;
    }

    public static function getUsersByCategory($category)
    {
        return User::where('role_id', $category)->get();
    }

    public static function getUsersEmailByCategory($category)
    {
        return User::where('role_id', $category)->pluck('email')->toArray();
    }

    public static function saveFile($path, $file){
        if(! $file || !$path)
            return [];

        $path = $file->storeAs($path, $file->getClientOriginalName(), 'public');
        $filename = $file->getClientOriginalName();

        return [
            "name" => $filename,
            "path" => $path,
            "saved_path" => config('app.url') .'/storage/'.$path
        ];
    }

    public static function emailHelper($emailData, $recipients, $ccs = null, $attachment = null){
        // Send the email
        $mail = Mail::to($recipients);

        if($ccs){
            $mail = $mail->cc($ccs);
        }

        $mail->send(new NotificationMail($emailData));

        return;
    }

    public static function status($id){
        $status = Status::find($id); 
        return $status ? $status->status : '';
    }

    public static function applicationDetails($builder)
    {
        return $builder->join('institutions', 'applications.institution_id', '=', 'institutions.id')
        ->join('institution_memberships', 'institutions.id', '=', 'institution_memberships.institution_id')
        ->join('membership_categories', 'institution_memberships.membership_category_id', '=', 'membership_categories.id')
        ->join('application_field_uploads', 'applications.id', '=', 'application_field_uploads.application_id')
        ->join('application_fields', 'application_field_uploads.application_field_id', '=', 'application_fields.id')
        ->select(
            'institutions.id AS institution_id',
            'applications.id AS application_id',
            'applications.concession_stage AS concession_stage',
            'applications.amount_received_by_fsd AS amount_received_by_fsd',
            'applications.mbg_review_stage AS mbg_review_stage',
            'applications.meg_review_stage AS meg_review_stage',
            'applications.meg2_review_stage AS meg2_review_stage',
            'applications.fsd_review_stage AS fsd_review_stage',
            'membership_categories.id AS category_id', 
            'membership_categories.name AS category_name',
            DB::raw("MAX(CASE WHEN application_fields.name = 'companyName' THEN application_field_uploads.uploaded_field END) AS company_name"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'companyEmailAddress' THEN application_field_uploads.uploaded_field END) AS company_email"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'applicationPrimaryContactEmailAddress' THEN application_field_uploads.uploaded_field END) AS primary_contact_email"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'rcNumber' THEN application_field_uploads.uploaded_field END) AS rc_number"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'registeredOfficeAddress' THEN application_field_uploads.uploaded_field END) AS registered_office_address"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'registeredOfficeAddress' THEN application_field_uploads.uploaded_field END) AS registered_office_address"),
        )
        ->groupBy('institutions.id', 'applications.id', 'membership_categories.id', 'membership_categories.name', 'applications.concession_stage', 'applications.amount_received_by_fsd', 'applications.fsd_review_stage', 'applications.mbg_review_stage', 'applications.meg_review_stage', 'applications.meg2_review_stage');
    }

    public static function applicationStatusHelper(Application $application, $newstatus, $nextOffice, $comment = null, $file = null){
        $status = new Status();
        $status->status = $newstatus;
        $status->comment = $comment;
        $status->file = $file;
        $status->save();

        $application->status = $status->id;
        $application->office_to_perform_next_action = $nextOffice;
        $application->save();

        $application->status()->save($status);

        return;
    }
}
