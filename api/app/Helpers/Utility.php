<?php
namespace App\Helpers;

use App\Mail\NotificationMail;
use App\Models\Application;
use App\Models\MembershipCategoryPostition;
use App\Models\Position;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Notifications\InfoTableNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

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

    public static function checkPasswordExpiry(User $user): bool
    {
        $password = $user->passwords()->orderByDesc('id')->first();

        if (!$password) {
            return true;
        }

        if (Carbon::parse($password->created_at)->addMonths(config('app.password_expiry')) <= Carbon::now()) {
            return false;
        }

        return true;
    }

    public static function checkPasswordPolicy($user, $password)
    {
        $passwords = $user->passwords()->latest()->take(config('app.unique_password'))->pluck('password');

        foreach ($passwords as $old_password) {
            if (Hash::check($password, $old_password)) {
                return false;
            }

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

    public static function saveFile($path, $file)
    {
        if (!$file || !$path) {
            return [];
        }

        $path = $file->storeAs($path, $file->getClientOriginalName(), 'public');
        $filename = $file->getClientOriginalName();

        return [
            "name" => $filename,
            "path" => $path,
            "saved_path" => config('app.url') . '/storage/' . $path,
        ];
    }

    public static function emailHelper($emailData, $recipients, $ccs = [], $attachment = []){
        // Send the email
        $mail = Mail::to($recipients);

        if ($ccs) {
            $mail = $mail->cc($ccs);
        }

        $mail->send(new NotificationMail($emailData, $attachment));

        return;
    }

    // public static function notifyApplicantAndContact($application_id, $applicant, $emailData, $ccs = [], $attachment = []){
    //     $data = Application::where('applications.id', $application_id);
    //     $data = Utility::applicationDetails($data);
    //     $data = $data->first();
    //     $companyEmail = $data->company_email;
    //     $contactEmail = $data->primary_contact_email;

    //     // Recipient email addresses
    //     $toEmails = [$applicant->email, $companyEmail, $contactEmail];
    //     return self::emailHelper($emailData, $toEmails, $ccs, $attachment);
    // }

    // public static function notifyApplicantAndContactArUpdate($application){
    //     $institution = $application->institution;
    //     $membershipCategory = $institution->membershipCategories->first();
    //     $applicant = User::find($application->submitted_by);
    //     $emailData = [
    //         'name' => "{$applicant->first_name} {$applicant->last_name}",
    //         'subject' => MailContents::ApplicantArUpdateSubject(),
    //         'content' => MailContents::ApplicantArUpdateMail($membershipCategory->name)
    //     ];
    //     $Meg = self::getUsersEmailByCategory(Role::MEG);
    //     return self::notifyApplicantAndContact($application->id, $applicant, $emailData, $Meg);
    // }

    public static function notifyApplicantAndContact($application_id, $applicant, $emailData, $ccs = [], $attachment = []){
        $data = Application::where('applications.id', $application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();
        $companyEmail = $data->company_email;
        $contactEmail = $data->primary_contact_email;

        // Recipient email addresses
        $toEmails = [$applicant->email, $companyEmail, $contactEmail];
        return self::emailHelper($emailData, $toEmails, $ccs, $attachment);
    }

    public static function notifyApplicantAndContactArUpdate($application){
        $institution = $application->institution;
        $membershipCategory = $institution->membershipCategories->first();
        $applicant = User::find($application->submitted_by);
        $emailData = [
            'name' => "{$applicant->first_name} {$applicant->last_name}",
            'subject' => MailContents::ApplicantArUpdateSubject(),
            'content' => MailContents::ApplicantArUpdateMail($membershipCategory->name)
        ];
        $Meg = self::getUsersEmailByCategory(Role::MEG);
        return self::notifyApplicantAndContact($application->id, $applicant, $emailData, $Meg);
    }

    public static function status($id)
    {
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
            'applications.completed_at AS completed_at',
            'applications.status AS status',
            'applications.is_applicant_executed_membership_agreement AS is_applicant_executed_membership_agreement',
            'applications.all_ar_uploaded AS all_ar_uploaded',
            'applications.e_success_letter AS e_success_letter',
            'applications.meg_executed_membership_agreement AS meg_executed_membership_agreement',
            'applications.e_success_letter_send AS e_success_letter_send',
            'applications.member_agreement_send AS member_agreement_send',
            'applications.all_ar_uploaded AS all_ar_uploaded',
            'membership_categories.id AS category_id',
            'membership_categories.name AS category_name',

            DB::raw("MAX(CASE WHEN application_fields.name = 'companyName' THEN application_field_uploads.uploaded_field END) AS company_name"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'companyEmailAddress' THEN application_field_uploads.uploaded_field END) AS company_email"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'applicationPrimaryContactEmailAddress' THEN application_field_uploads.uploaded_field END) AS primary_contact_email"),

                //BASIC DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyName' THEN application_field_uploads.uploaded_field END) AS companyName"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyEmailAddress' THEN application_field_uploads.uploaded_field END) AS companyEmailAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'rcNumber' THEN application_field_uploads.uploaded_field END) AS rcNumber"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'registeredOfficeAddress' THEN application_field_uploads.uploaded_field END) AS registeredOfficeAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'dateOfIncorporation' THEN application_field_uploads.uploaded_field END) AS dateOfIncorporation"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'placeOfIncorporation' THEN application_field_uploads.uploaded_field END) AS placeOfIncorporation"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'natureOfBusiness' THEN application_field_uploads.uploaded_field END) AS natureOfBusiness"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyTelephoneNumber' THEN application_field_uploads.uploaded_field END) AS companyTelephoneNumber"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'corporateWebsiteAddress' THEN application_field_uploads.uploaded_field END) AS corporateWebsiteAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'authorisedShareCapitalCurrency' THEN application_field_uploads.uploaded_field END) AS authorisedShareCapitalCurrency"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'authorisedShareCapital' THEN application_field_uploads.uploaded_field END) AS authorisedShareCapital"),

                //PRIMARY CONTACT DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'applicationPrimaryContactEmailAddress' THEN application_field_uploads.uploaded_field END) AS applicationPrimaryContactEmailAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'applicationPrimaryContactName' THEN application_field_uploads.uploaded_field END) AS applicationPrimaryContactName"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'applicationPrimaryContactTelephone' THEN application_field_uploads.uploaded_field END) AS applicationPrimaryContactTelephone"),

                //BANK DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailName' THEN application_field_uploads.uploaded_field END) AS bankDetailName"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailAddress' THEN application_field_uploads.uploaded_field END) AS bankDetailAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTelephone' THEN application_field_uploads.uploaded_field END) AS bankDetailTelephone"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailMobileNumberOfAccountManager' THEN application_field_uploads.uploaded_field END) AS bankDetailMobileNumberOfAccountManager"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailEmailAddressOfAccountManager' THEN application_field_uploads.uploaded_field END) AS bankDetailEmailAddressOfAccountManager"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTypeOfAccount' THEN application_field_uploads.uploaded_field END) AS bankDetailTypeOfAccount"),

                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailNameOne' THEN application_field_uploads.uploaded_field END) AS bankDetailNameOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailAddressOne' THEN application_field_uploads.uploaded_field END) AS bankDetailAddressOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTelephoneOne' THEN application_field_uploads.uploaded_field END) AS bankDetailTelephoneOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailMobileNumberOfAccountManagerOne' THEN application_field_uploads.uploaded_field END) AS bankDetailMobileNumberOfAccountManagerOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailEmailAddressOfAccountManagerOne' THEN application_field_uploads.uploaded_field END) AS bankDetailEmailAddressOfAccountManagerOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTypeOfAccountOne' THEN application_field_uploads.uploaded_field END) AS bankDetailTypeOfAccountOne"),

                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailNameTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailNameTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailAddressTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailAddressTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTelephoneTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailTelephoneTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailMobileNumberOfAccountManagerTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailMobileNumberOfAccountManagerTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailEmailAddressOfAccountManagerTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailEmailAddressOfAccountManagerTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankDetailTypeOfAccountTwo' THEN application_field_uploads.uploaded_field END) AS bankDetailTypeOfAccountTwo"),

                //BANK LICENSE DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'bankingLicense' THEN application_field_uploads.uploaded_field END) AS bankingLicense"),

                //DISCIPLINARY DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyDisciplinary' THEN application_field_uploads.uploaded_field END) AS companyDisciplinary"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyDisciplinaryOne' THEN application_field_uploads.uploaded_field END) AS companyDisciplinaryOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyDisciplinaryTwo' THEN application_field_uploads.uploaded_field END) AS companyDisciplinaryTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyDisciplinaryThree' THEN application_field_uploads.uploaded_field END) AS companyDisciplinaryThree"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'companyDisciplinaryFour' THEN application_field_uploads.uploaded_field END) AS companyDisciplinaryFour"),

                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinary' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinary"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryOne' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryTwo' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryThree' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryThree"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryFour' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryFour"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryFive' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryFive"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinarySix' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinarySix"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinarySeven' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinarySeven"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'mdceoDisciplinaryEight' THEN application_field_uploads.uploaded_field END) AS mdceoDisciplinaryEight"),

                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinary' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinary"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinaryOne' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinaryOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinaryTwo' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinaryTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinaryThree' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinaryThree"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinaryFour' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinaryFour"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'treasureDisciplinaryFive' THEN application_field_uploads.uploaded_field END) AS treasureDisciplinaryFive"),

                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinary' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinary"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinaryOne' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinaryOne"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinaryTwo' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinaryTwo"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinaryThree' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinaryThree"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinaryFour' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinaryFour"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'chiefComplianceOfficerDisciplinaryFive' THEN application_field_uploads.uploaded_field END) AS chiefComplianceOfficerDisciplinaryFive"),

                //CUSTODIAN DETAILS
                DB::raw("MAX(CASE WHEN application_fields.name = 'custodianInformationName' THEN application_field_uploads.uploaded_field END) AS custodianInformationName"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'custodianInformationAddress' THEN application_field_uploads.uploaded_field END) AS custodianInformationAddress"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'custodianInformationTelephone' THEN application_field_uploads.uploaded_field END) AS custodianInformationTelephone"),
                DB::raw("MAX(CASE WHEN application_fields.name = 'custodianInformationMobileNumberOfContact' THEN application_field_uploads.uploaded_field END) AS custodianInformationMobileNumberOfContact"),

            //SUPPORTING DOCUMENTS
            DB::raw("MAX(CASE WHEN application_fields.name = 'CompanyOverview' THEN application_field_uploads.uploaded_file END) AS CompanyOverview"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'certificateOfIncorporation' THEN application_field_uploads.uploaded_file END) AS certificateOfIncorporation"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'memorandumAndArticlesOfAssociation' THEN application_field_uploads.uploaded_file END) AS memorandumAndArticlesOfAssociation"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'particularsOfDirectors' THEN application_field_uploads.uploaded_file END) AS particularsOfDirectors"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'particularsOfShareholders' THEN application_field_uploads.uploaded_file END) AS particularsOfShareholders"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'evidenceOfRegistration' THEN application_field_uploads.uploaded_file END) AS evidenceOfRegistration"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'detailedResumesOfSEC' THEN application_field_uploads.uploaded_file END) AS detailedResumesOfSEC"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'evidenceOfCompliance' THEN application_field_uploads.uploaded_file END) AS evidenceOfCompliance"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'listOfAuthorisedRepresentatives' THEN application_field_uploads.uploaded_file END) AS listOfAuthorisedRepresentatives"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'latestFidelityBond' THEN application_field_uploads.uploaded_file END) AS latestFidelityBond"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'mostRecentYearAuditedFinancialStatements' THEN application_field_uploads.uploaded_file END) AS mostRecentYearAuditedFinancialStatements"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'evidenceFXAuthorisedDealershipLicence' THEN application_field_uploads.uploaded_file END) AS evidenceFXAuthorisedDealershipLicence"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'evidenceOfPaymentOfApplicationFee' THEN application_field_uploads.uploaded_file END) AS evidenceOfPaymentOfApplicationFee"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'applicantDeclaration' THEN application_field_uploads.uploaded_file END) AS applicantDeclaration"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'dulyCompletedApplicationForm' THEN application_field_uploads.uploaded_file END) AS dulyCompletedApplicationForm"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'companyProfile' THEN application_field_uploads.uploaded_file END) AS companyProfile"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'letterOfExpressionOfInterest' THEN application_field_uploads.uploaded_file END) AS letterOfExpressionOfInterest"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'resumeOfDealers' THEN application_field_uploads.uploaded_file END) AS resumeOfDealers"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'evidenceOfMinimumShareholder' THEN application_field_uploads.uploaded_file END) AS evidenceOfMinimumShareholder"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'confirmationOfTechnicalKnowledge' THEN application_field_uploads.uploaded_file END) AS confirmationOfTechnicalKnowledge"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'thomsonReutersContractForm' THEN application_field_uploads.uploaded_file END) AS thomsonReutersContractForm"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'thomsonReutersCertificateOfIncorporation' THEN application_field_uploads.uploaded_file END) AS thomsonReutersCertificateOfIncorporation"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'thomsonReutersMemorandumAndArticles' THEN application_field_uploads.uploaded_file END) AS thomsonReutersMemorandumAndArticles"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'thomsonReutersParticularsOfDirectors' THEN application_field_uploads.uploaded_file END) AS thomsonReutersParticularsOfDirectors"),
            DB::raw("MAX(CASE WHEN application_fields.name = 'thomsonReutersEvidenceOfRegulatoryStatus' THEN application_field_uploads.uploaded_file END) AS thomsonReutersEvidenceOfRegulatoryStatus")
        )
        ->groupBy('institutions.id', 'applications.id', 'membership_categories.id', 'membership_categories.name', 'applications.concession_stage', 'applications.amount_received_by_fsd',
        'applications.fsd_review_stage', 'applications.mbg_review_stage', 'applications.meg_review_stage', 'applications.meg2_review_stage', 'applications.completed_at',
        'applications.is_applicant_executed_membership_agreement', 'applications.all_ar_uploaded', 'applications.member_agreement_send', 'applications.e_success_letter_send',
        'applications.e_success_letter', 'applications.meg_executed_membership_agreement','applications.status');
    }

    public static function applicationStatusHelper(Application $application, $newstatus, $currentOffice, $nextOffice, $comment = null, $file = null)
    {
        $status = new Status();
        $status->status = $newstatus;
        $status->office = $currentOffice;
        $status->comment = $comment;
        $status->file = $file;
        $status->save();

        $application->status = $status->id;
        $application->office_to_perform_next_action = $nextOffice;
        $application->show_form = 0;
        $application->save();

        $application->status()->save($status);

        return;
    }

    public static function getOfficeStatus()
    {

    }

    public static function sendMailGroupNotification($users, $category)
    {
        $body = [];
        
        foreach($users as $user){
            $firstname = $user->first_name;
            $lastname = $user->last_name;
            $fullname = $user->first_name." ".$user->last_name." ".$user->middle_name;
            $position = Position::find($user->position_id);
            $mailgroup = MembershipCategoryPostition::where([
                'category_id' => $category->id,
                'position_id' => $position->id
            ])->first();

            $body[] = [$category->name, $position->name, $mailgroup->groupMail->email, $firstname, $lastname, $fullname, $user->email];

        }

        $data = [
            "header" => ["Membership Category", "Position", "Mailing Group", "First Name", "Surname", "Full Name", "Email Address"],
            "body" => $body
        ];

        if(count($body)){
            //FMDQ Help Desk Cc MEG
            $HelpDesk = Utility::getUsersByCategory(Role::HELPDESK);
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            Notification::send($HelpDesk, new InfoTableNotification(MailContents::helpdeskMailingMail(), MailContents::helpdeskMailingSubject($category->name), $data, $Meg));
        }

        logger(json_encode($data));
        return true;
    }
}
