<?php
namespace App\Helpers;

use App\Http\Resources\ApplicationResource;
use App\Mail\FinalApplicationMail;
use App\Mail\NotificationMail;
use App\Models\Application;
use App\Models\Education\EventRegistration;
use App\Models\Invoice;
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
            // "saved_path" => config('app.url') . '/storage/app/public/' . $path,
        ];
    }

    public static function emailHelper($emailData, $recipients, $ccs = [], $attachment = [])
    {
        // Send the email
        $mail = Mail::to($recipients);

        if ($ccs) {
            $mail = $mail->cc($ccs);
        }

        $mail->send(new NotificationMail($emailData, $attachment));

        return;
    }

    public static function notifyApplicantFinal($application_id, $emailData, $toEmails = [], $ccs = [], $attachment = [])
    {
        $application = Application::find($application_id);

        $mail = Mail::to($toEmails);

        if ($ccs) {
            $mail = $mail->cc($ccs);
        }

        $mail->send(new FinalApplicationMail($emailData, $application, $attachment));

        return;

    }

    public static function notifyApplicantAndContact($application_id, $applicant, $emailData, $ccs = [], $attachment = [])
    {
        $data = Application::where('applications.id', $application_id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();
        $companyEmail = $data->company_email;
        $contactEmail = $data->primary_contact_email;

        // Recipient email addresses
        $toEmails = [$applicant->email, $companyEmail];

        if ($contactEmail) {
            array_push($toEmails, $companyEmail);
        }

        return self::emailHelper($emailData, $toEmails, $ccs, $attachment);
    }

    public static function notifyApplicantAndContactArUpdate($application)
    {
        $membershipCategory = $application->membershipCategory;
        $applicant = User::find($application->submitted_by);
        $emailData = [
            'name' => "{$applicant->first_name} {$applicant->last_name}",
            'subject' => MailContents::ApplicantArUpdateSubject(),
            'content' => MailContents::ApplicantArUpdateMail($membershipCategory->name),
        ];
        $Meg = self::getUsersEmailByCategory(Role::MEG);
        return self::notifyApplicantAndContact($application->id, $applicant, $emailData, $Meg);
    }

    public static function status($id)
    {
        $status = Status::find($id);
        return $status ? $status->status : '';
    }

    public static function applicationData($builder)
    {
        return $builder->join('institutions', 'applications.institution_id', '=', 'institutions.id')
            ->join('membership_categories', 'applications.membership_category_id', '=', 'membership_categories.id')
            ->leftJoin('application_field_uploads', 'applications.id', '=', 'application_field_uploads.application_id')
            ->leftJoin('application_fields', 'application_field_uploads.application_field_id', '=', 'application_fields.id')
            ->select(
                'institutions.id AS institution_id',
                'applications.id AS application_id',
                'applications.office_to_perform_next_action AS office_to_perform_next_action',
                'applications.uuid AS uuid',
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
                DB::raw("MAX(CASE WHEN application_fields.name = 'CompanyLogo' THEN application_field_uploads.uploaded_file END) AS CompanyLogo"),
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
                'applications.e_success_letter', 'applications.meg_executed_membership_agreement', 'applications.status');
    }

    public static function applicationDetails($builder)
    {
        return $builder->join('institutions', 'applications.institution_id', '=', 'institutions.id')
            ->join('membership_categories', 'applications.membership_category_id', '=', 'membership_categories.id')
            ->join('application_field_uploads', 'applications.id', '=', 'application_field_uploads.application_id')
            ->join('application_fields', 'application_field_uploads.application_field_id', '=', 'application_fields.id')
            ->select(
                'institutions.id AS institution_id',
                'applications.id AS application_id',
                'applications.uuid AS uuid',
                'applications.office_to_perform_next_action AS office_to_perform_next_action',
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
                DB::raw("MAX(CASE WHEN application_fields.name = 'CompanyLogo' THEN application_field_uploads.uploaded_file END) AS CompanyLogo"),
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
                'applications.e_success_letter', 'applications.meg_executed_membership_agreement', 'applications.status', 'applications.uuid', 'applications.office_to_perform_next_action');
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

        $hasMailingGroup = false;

        foreach ($users as $user) {
            $firstname = $user->first_name;
            $lastname = $user->last_name;
            $fullname = $user->first_name . " " . $user->last_name . " " . $user->middle_name;
            $position = Position::find($user->position_id);
            $mailgroup = MembershipCategoryPostition::where([
                'category_id' => $category->id,
                'position_id' => $position->id,
            ])->first();
            $group_mail = $mailgroup->groupMail ? $mailgroup->groupMail->email : '';

            $hasMailingGroup = $hasMailingGroup && $group_mail ? true : false;

            $body[] = [$category->name, $position->name, $group_mail, $firstname, $lastname, $fullname, $user->email];

        }

        $data = [
            "header" => ["Membership Category", "Position", "Mailing Group", "First Name", "Surname", "Full Name", "Email Address"],
            "body" => $body,
        ];

        if (count($body) && $hasMailingGroup) {
            //FMDQ Help Desk Cc MEG
            $HelpDesk = Utility::getUsersByCategory(Role::HELPDESK);
            $Meg = Utility::getUsersEmailByCategory(Role::MEG);
            Notification::send($HelpDesk, new InfoTableNotification(MailContents::helpdeskMailingMail(), MailContents::helpdeskMailingSubject($category->name), $data, $Meg));
        }

        return true;
    }

    public static function getTotalFromInvoice(Invoice $invoice)
    {
        $invoiceContents = $invoice->contents;
        $total = 0;

        foreach ($invoiceContents as $invoiceContent) {

            if ($invoiceContent->type == 'credit') {
                $total -= $invoiceContent->value;
            }

            if ($invoiceContent->type == 'debit') {
                $total += $invoiceContent->value;
            }
        }

        return $total;
    }
    public static function getFileName($name, $path)
    {
        return Str::of(Str::slug($name, '-'))->upper() . "." . pathinfo($path, PATHINFO_EXTENSION);
    }

    public static function applicationReport()
    {

        $data = Application::where('applications.institution_id', '!=', null);
        $data = Utility::applicationDetails($data);
        $data = $data->get();

        $table = "<table>
                    <thead>
                        <tr>
                            <th scope='col'>Membership ID</th>
                            <th scope='col'>Institution</th>
                            <th scope='col'>Category</th>
                            <th scope='col'>Address</th>
                            <th scope='col'>Phone Number</th>
                            <th scope='col'>Email address</th>
                            <th scope='col'>Website</th>
                            <th scope='col'>Status</th>
                            <th scope='col'>Sign-on date</th>
                        <tr>
                    </thead>
                    <tbody>";
        foreach ($data as $setData) {

            $application = Application::find($setData->application_id);

            $table .= "<tr>
                                    <td scope='row'>{$application->reg_id}</td>
                                    <td>{$setData->companyName}</td>
                                    <td>{$setData->category_name}</td>
                                    <td>{$setData->registeredOfficeAddress}</td>
                                    <td>{$setData->companyTelephoneNumber}</td>
                                    <td>{$setData->companyEmailAddress}</td>
                                    <td>{$setData->corporateWebsiteAddress}</td>
                                    <td>{$setData->status_description}</td>
                                    <td>{$application->created_at}</td>
                                </tr>";
        }

        $table .= "</tbody>
                    </table>";
        return $table;

    }
    public static function educationReport()
    {
        // $records = EventRegistration::with(['user', 'event'])->where('is_del', 0)->where('event_id', $event->id)->latest()->get();
        $records = EventRegistration::with(['user', 'event'])->where('is_del', 0)->latest()->get();

        $table = "<table>
                    <thead>
                        <tr>
                            <th scope='col'>Registrant</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Event Name</th>
                            <th scope='col'>Event Description</th>
                            <th scope='col'>Event Date</th>
                            <th scope='col'>Status</th>
                            <th scope='col'>Fee</th>
                        <tr>
                    </thead>
                    <tbody>";
        foreach ($records as $setData) {

            $table .= "<tr>
                                    <td  scope='row'>{$setData->user->full_name}</td>
                                    <td>{$setData->user->email}</td>
                                    <td>{$setData->event->name}</td>
                                    <td>{$setData->event->description}</td>
                                    <td>{$setData->event->date}</td>
                                    <td>{$setData->status}</td>
                                    <td>{$setData->event->fee}</td>
                                </tr>";
        }

        $table .= "</tbody>
                    </table>";
        return $table;

    }
    public static function representativeReport()
    {
        $query = User::whereNotNull('institution_id');
        $query = $query->whereIn('role_id', [Role::ARAUTHORISER, Role::ARINPUTTER]);

        $users = $query->latest()->get();
        $table = "<table>
                        <thead>
                            <tr>
                                <th scope='col'>Surname</th>
                                <th scope='col'>First name</th>
                                <th scope='col'>Institution</th>
                                <th scope='col'>Category</th>
                                <th scope='col'>Position</th>
                                <th scope='col'>Email address</th>
                                <th scope='col'>Phone number</th>
                            <tr>
                        </thead>
                        <tbody>";
        foreach ($users as $setData) {

            $table .= "<tr>
                                        <td  scope='row'>{$setData->last_name}</td>
                                        <td>{$setData->first_name}</td>
                                        <td>{$setData->institution->name}</td>
                                        <td>{$setData->category->name}</td>
                                        <td>{$setData->position->name}</td>
                                        <td>{$setData->email}</td>
                                        <td>{$setData->phone}</td>
                                    </tr>";
        }

        $table .= "</tbody>
                        </table>";
        return $table;

    }

    public static function institutionApplicationReport($applicationId)
    {

        $data = Application::where('applications.uuid', $applicationId);
        $application_data = Utility::applicationDetails($data);
        $application_data = $application_data->get();

        $application_datas = ApplicationResource::collection($application_data);

        $table = "";

        $application_datas = json_decode($application_datas->toJson());

        foreach ($application_datas as $application_data) {

            $table = "
                <div>
            <div class='card-inner'>

              <div>

                <h5 class='title'>Basic Information</h5>

              </div>

              <table class='table table-striped table-bordered table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>S/N</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Company Name</td>
                    <td class='text-capitalize'>{$application_data->basic_details->companyName}</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>RC Number</td>
                    <td class='text-capitalize'>{$application_data->basic_details->rcNumber}</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Registered Office Address</td>
                    <td class='text-capitalize'>{$application_data->basic_details->registeredOfficeAddress}</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Town/City</td>
                    <td class='text-capitalize'>{$application_data->basic_details->placeOfIncorporation}</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Date of Incorporation</td>
                    <td class='text-capitalize'>{$application_data->basic_details->dateOfIncorporation}</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>Place of Incorporation</td>
                    <td class='text-capitalize'>{$application_data->basic_details->placeOfIncorporation}</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>Nature of Business</td>
                    <td class='text-capitalize'>{$application_data->basic_details->natureOfBusiness}</td>
                  </tr>
                  <tr>
                    <td>8</td>
                    <td>Company Primary Telephone Number</td>
                    <td class='text-capitalize'>{$application_data->basic_details->companyTelephoneNumber}</td>
                  </tr>
                  <tr>
                    <td>9</td>
                    <td>Company Secondary Telephone Number</td>
                    <td class='text-capitalize'>{$application_data->basic_details->companyTelephoneNumber}</td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td>Company Email Address</td>
                    <td class='text-capitalize'>{$application_data->basic_details->companyEmailAddress}</td>
                  </tr>
                  <tr>
                    <td>11</td>
                    <td>Company Website Address</td>
                    <td class='text-capitalize'>{$application_data->basic_details->corporateWebsiteAddress}</td>
                  </tr>
                  <tr>
                    <td>12</td>
                    <td>Authorised Share Capital</td>
                    <td class='text-capitalize'>{$application_data->basic_details->authorisedShareCapital}</td>
                  </tr>
                  <tr>
                    <td>13</td>
                    <td>Authorised Share Capital Currency</td>
                    <td class='text-capitalize'>{$application_data->basic_details->authorisedShareCapitalCurrency}</td>
                  </tr>

                </tbody>
              </table>
            </div>";

            if ($application_data->primary_contact_details->applicationPrimaryContactName) {
                $table .= "
                        <div class='card-inner'>
                            <h5>Primary Contact Details</h5>

                            <table class='table table-striped table-bordered table-hover'>
                                <thead>
                                    <tr>
                                        <th scope='col'>S/N</th>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Primary Contact Name</td>
                                        <td class='text-capitalize'>{$application_data->primary_contact_details->applicationPrimaryContactName}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Primary Contact Email Address</td>
                                        <td class='text-capitalize'>{$application_data->primary_contact_details->applicationPrimaryContactEmailAddress}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Primary Contact Telephone</td>
                                        <td class='text-capitalize'>{$application_data->primary_contact_details->applicationPrimaryContactTelephone}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>";
            }

            $table .= " <div class='card-inner'>
                        <div tag='h5'>Bank Details</div>

                        <table class='table table-striped table-bordered table-hover'>
                            <thead>
                            <tr>
                                <th scope='col'>SN</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Value</th>
                            </tr>
                            </thead>
                                <tbody>";

            if ($application_data->bank_details->bankDetailName) {
                $table .= "
                        <tr>
                            <td>1</td>
                            <td>Bank Detail</td>
                            <td class='text-capitalize'>{$application_data->bank_details->bankDetailName}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Bank Address</td>
                            <td class='text-capitalize'>{$application_data->bank_details->bankDetailAddress}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Bank Telephone</td>
                            <td class='text-capitalize'>{$application_data->bank_details->bankDetailTelephone}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Type Of Account</td>
                            <td class='text-capitalize'>{$application_data->bank_details->bankDetailTypeOfAccount}</td>
                        </tr>";
            }

            if ($application_data->bank_details->bankDetailNameOne) {
                $table .= "

                    <tr>
                      <td>1</td>
                      <td>Bank Detail</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailNameOne}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bank Address</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailAddressOne}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Bank Telephone</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailTelephoneOne}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Type Of Account</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailTypeOfAccountOne}</td>
                    </tr>";
            }

            if ($application_data->bank_details->bankDetailNameTwo) {
                $table .= "
                    <tr>
                      <td>1</td>
                      <td>Bank Detail</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailNameTwo}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bank Address</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailAddressTwo}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Bank Telephone</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailTelephoneTwo}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Type Of Account</td>
                      <td class='text-capitalize'>{$application_data->bank_details->bankDetailTypeOfAccountTwo}</td>
                    </tr>";
            }

            $table .= "</tbody>
              </table>
            </div>";

            if ($application_data->bank_license_details->bankingLicense) {
                $table .= "

              <div class='card-inner'>
                <div tag='h5'>Bank License</div>

                <table class='table table-striped table-bordered table-hover'>
                  <thead>
                    <tr>
                      <th scope='col'>S/N</th>
                      <th scope='col'>Name</th>
                      <th scope='col'>Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Banking License</td>
                      <td class='text-capitalize'>{$application_data->bank_license_details->bankingLicense}</td>
                    </tr>


                  </tbody>
                </table>
              </div>";
            }

            $table .= "
            <div class='card-inner'>
              <div tag='h5'>Disciplinary History</div>

              <table class='table table-striped table-bordered table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>Name</th>
                    <th scope='col'>Value</th>
                  </tr>
                </thead>
                <tbody>";

            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinary) {
                $table .= "
                    <tr>
                      <td>chiefComplianceOfficerDisciplinary</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinary}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryFive) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryFive}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryFour) {
                $table .= "
                    <tr>
                      <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryFour}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryOne) {
                $table .= "
                    <tr>
                      <td>Ever been convicted of any criminal offence? </td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryOne}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryThree) {
                $table .= "
                    <tr>
                      <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryThree}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryTwo) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->chiefComplianceOfficerDisciplinaryTwo}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->companyDisciplinary) {
                $table .= "
                    <tr>
                      <td>companyDisciplinary</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->companyDisciplinary}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->companyDisciplinaryFour) {
                $table .= "
                    <tr>
                      <td>Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? </td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->companyDisciplinaryFour}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->companyDisciplinaryOne) {
                $table .= "
                    <tr>
                      <td>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->companyDisciplinaryOne}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->companyDisciplinaryThree) {
                $table .= "
                    <tr>
                      <td>Has your company, or any of its affiliates, ever been refused any Fidelity Bond?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->companyDisciplinaryThree}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->companyDisciplinaryTwo) {
                $table .= "
                    <tr>
                      <td>Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->companyDisciplinaryTwo}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinary) {
                $table .= "
                    <tr>
                      <td>mdceoDisciplinary</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinary}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinaryEight) {
                $table .= "
                    <tr>
                      <td>Ever been disqualified from acting as a Director?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryEight}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->mdceoDisciplinaryFive) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryFive}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinaryFour) {
                $table .= "
                    <tr>
                      <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryFour}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinaryOne) {
                $table .= "
                    <tr>
                      <td>Ever been convicted of any criminal offence?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryOne}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinarySeven) {
                $table .= "
                    <tr>
                      <td>Ever had such authorisation, membership or licence (referred to above) revoked or terminated?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinarySeven}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinarySix) {
                $table .= "
                    <tr>
                      <td>Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinarySix}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinaryThree) {
                $table .= "
                    <tr>
                      <td>Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryThree}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->mdceoDisciplinaryTwo) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->mdceoDisciplinaryTwo}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->treasureDisciplinary) {
                $table .= "
                    <tr>
                      <td>treasureDisciplinary</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinary}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->treasureDisciplinaryFive) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinaryFive}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->treasureDisciplinaryFour) {
                $table .= "
                    <tr>
                      <td>'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinaryFour}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->treasureDisciplinaryOne) {
                $table .= "
                    <tr>
                      <td>Ever been convicted of any criminal offence?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinaryOne}</td>
                    </tr>";
            }

            if ($application_data->disciplinary_details->treasureDisciplinaryThree) {
                $table .= "
                    <tr>
                      <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinaryThree}</td>
                    </tr>";
            }
            if ($application_data->disciplinary_details->treasureDisciplinaryTwo) {
                $table .= "
                    <tr>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td class='text-capitalize'>{$application_data->disciplinary_details->treasureDisciplinaryTwo}</td>
                    </tr>";
            }

            $table .= " </tbody>
              </table>
            </div>";

            if ($application_data->custodian_details->custodianInformationName) {
                $table .= "<div class='card-inner'>
                        <div tag='h5'>Custodian Information</div>

                        <table class='table table-striped table-bordered table-hover'>
                        <thead>
                            <tr>
                            <th scope='col'>S/N</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>Value</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                            <td>1</td>
                            <td>Name</td>
                            <td class='text-capitalize'>{$application_data->custodian_details->custodianInformationName}</td>
                            </tr>
                            <tr>
                            <td>2</td>
                            <td> Address</td>
                            <td class='text-capitalize'>{$application_data->custodian_details->custodianInformationAddress}</td>
                            </tr>
                            <tr>
                            <td>3</td>
                            <td>Mobile Contact</td>
                            <td class='text-capitalize'>{$application_data->custodian_details->custodianInformationMobileNumberOfContact}</td>
                            </tr>
                            <tr>
                            <td>4</td>
                            <td>Telephone</td>
                            <td class='text-capitalize'>{$application_data->custodian_details->custodianInformationTelephone}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>";
            }

            $table .= "<div class='card-inner'>
              <div tag='h5'>Key Officers</div>

              <table class='table table-striped table-bordered table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>S/N</th>
                    <th scope='col'>Full Name</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>Reg ID</th>
                    <th scope='col'>Status</th>
                  </tr>
                </thead>
                <tbody>";

            foreach ($application_data->ars as $user) {
                $status = $user->member_status == 'active' ? 'Active' : 'Suspended';
                $table .= "<tr>
                      <th scope='row'></th>
                      <td>{$user->full_name}</td>
                      <td>{$user->email}</td>
                      <td>{$user->reg_id}</td>
                      <td>{$status}</td>
                    </tr>";
            }

            $table .= "</tbody>
              </table>
            </div>

            <div class='card-inner'>
              <div tag='h5'>Supporting Documents</div>

              <table class='table table-striped table-bordered table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Name</th>
                    <th scope='col' class='width-30'>Value</th>
                  </tr>
                </thead>
                <tbody>";

            foreach ($application_data->required_documents as $required_document) {
                $status = $required_document->uploaded_file ? 'Uploaded' : $required_document->uploaded_field;
                $table .= "<tr>
                      <th scope='row'></th>
                      <td>{$required_document->description}</td>
                      <td>{$status}</td>
                    </tr>";
            }

            $table .= "</tbody>
              </table>
            </div>

            <div class='card-inner'>
              <div tag='h5'>Payment Information</div>

              <table class='table table-striped table-bordered table-hover'>
                <thead>
                  <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Invoice Number</td>
                    <td class='text-capitalize'>{$application_data->payment_information->invoice_number}</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Payment Reference</td>
                    <td class='text-capitalize'>{$application_data->payment_information->reference}</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Date of Payment</td>
                    <td class='text-capitalize'>{$application_data->payment_information->date_paid}</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Amount Paid</td>
                    <td class='text-capitalize'>{$application_data->payment_details->total}</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Concession Amount</td>
                    <td class='text-capitalize'>{$application_data->payment_details->concession_amount}</td>
                  </tr>
                </tbody>
              </table>
            </div>

        </div>";

            // foreach ($users as $setData) {

            //     $table .= "<tr>
            //                                 <td  scope='row'>{$setData->last_name}</td>
            //                                 <td>{$setData->first_name}</td>
            //                                 <td>{$setData->institution->name}</td>
            //                                 <td>{$setData->category->name}</td>
            //                                 <td>{$setData->position->name}</td>
            //                                 <td>{$setData->email}</td>
            //                                 <td>{$setData->phone}</td>
            //                             </tr>";
            // }

            // $table .= "</tbody>
            //                 </table>";
        }

        return $table;

    }

    public static function categoryNameWithPronoun($categoryName)
    {
        $catList = explode(' ', $categoryName);
        $anList = ['Associate', 'Affiliate'];
        $pronoun = (in_array($catList[0], $anList)) ? "an" : "a";
        return "$pronoun $categoryName";
    }

    public static function categoryNameFromWebsite($categoryName)
    {
        $list = ['(Individual)', '(Corporate)'];
        return str_replace($list, ' ', $categoryName);
    }
}
