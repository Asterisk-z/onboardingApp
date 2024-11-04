<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProcessTimestamp extends Model
{
    use HasFactory;
    protected $guarded = [];

    const STEPS = [
        'ACA' => 'applicant_completed_application',
        'MCC' => 'mbg_completed_concession',
        'AMP' => 'applicant_made_payment',
        'FVP' => 'fsd_validated_payment',
        'MAP' => 'mbg_approve_payment',
        'MRAD' => 'meg_review_application_document',
        'MAAD' => 'meg2_approve_application_document',
        'MSAA' => 'meg_send_agreement_to_applicant',
        'AUA' => 'applicant_upload_agreement',
        'AAAA' => 'applicant_added_all_ar',
        'MUSA' => 'meg_upload_signed_agreement',
        'M2EL' => 'meg2_send_esuccess_letter',
    ];

    public function toArray()
    {
        return [
            // 'application_name' => $this->application->name,
            // 'application' => $this->application,
            'application_reg_id' => $this->application->reg_id,
            'application_type' => $this->application->application_type,
            'institution_name' => getInstitutionFieldValue($this->application, 'companyName'),
            'application_id' => $this->application_id,
            'applicant_completed_application' => $this->applicant_completed_application ?? false,
            'mbg_completed_concession' => $this->mbg_completed_concession ?? false,
            'applicant_made_payment' => $this->applicant_made_payment ?? false,
            'fsd_validated_payment' => $this->fsd_validated_payment ?? false,
            'mbg_approve_payment' => $this->mbg_approve_payment ?? false,
            'meg_review_application_document' => $this->meg_review_application_document ?? false,
            'meg2_approve_application_document' => $this->meg2_approve_application_document ?? false,
            'meg_send_agreement_to_applicant' => $this->meg_send_agreement_to_applicant ?? false,
            'applicant_upload_agreement' => $this->applicant_upload_agreement ?? false,
            'applicant_added_all_ar' => $this->applicant_added_all_ar ?? false,
            'meg_upload_signed_agreement' => $this->meg_upload_signed_agreement ?? false,
            'meg2_send_esuccess_letter' => $this->meg2_send_esuccess_letter ?? false,
        ];
    }

    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }
}
