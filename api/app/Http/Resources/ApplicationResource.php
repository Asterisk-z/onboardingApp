<?php

namespace App\Http\Resources;

use App\Models\Application;
use App\Models\User;
use App\Traits\ApplicationTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    use ApplicationTraits;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $application = Application::find($this->application_id);
        return [
            "internal" => [
                "application_uuid" => $this->uuid,
                'application_type' => $application->application_type,
                'application_type_status' => $application->application_type_status,
                "office_to_perform_next_action" => $this->office_to_perform_next_action,
                "application_id" => $this->application_id,
                "institution_id" => $this->institution_id,
                'institution' => $this->institutionStatus($application->institution_id),
                "concession_stage" => $this->concession_stage,
                "disclosure_stage" => $this->disclosure_stage,
                "amount_received_by_fsd" => $this->amount_received_by_fsd ? number_format($this->amount_received_by_fsd, 2) : $this->amount_received_by_fsds,
                "mbg_review_stage" => $this->mbg_review_stage,
                "meg_review_stage" => $this->meg_review_stage,
                "meg2_review_stage" => $this->meg2_review_stage,
                "fsd_review_stage" => $this->fsd_review_stage,
                "category_id" => $this->category_id,
                "category_name" => $this->category_name,
                "completed_at" => $this->completed_at,
                "is_meg_executed_membership_agreement" => $application->is_meg_executed_membership_agreement,
                "is_applicant_executed_membership_agreement" => $this->is_applicant_executed_membership_agreement,
                "membership_agreement" => $application->membership_agreement ? $application->membership_agreement : null,
                "member_agreement" => $application->agreement ? config('app.url') . '/storage/app/public/' . $application->membership_agreement : null,
                "member_agreement_preview" => $application->agreement ? route('agreementPreview', $this->uuid) : false,
                "e_success_letter_preview" => $application->eSuccess ? route('eSuccessPreview', $this->uuid) : false,
                "has_member_agreement" => $application->agreement ? true : false,
                'has_e_success' => $application->eSuccess ? true : false,
                // "membership_agreement" => $application->membership_agreement ? config('app.url') . '/public/assets/membership_agreement/' . $application->membership_agreement : null,
                "meg_executed_membership_agreement" => $application->meg_executed_membership_agreement ? config('app.url') . '/storage/app/public/' . $application->meg_executed_membership_agreement : null,
                "applicant_executed_membership_agreement" => $application->applicant_executed_membership_agreement ? config('app.url') . '/storage/app/public/' . $application->applicant_executed_membership_agreement : null,
                "e_success_letter" => $application->e_success_letter ? config('app.url') . '/storage/app/public/' . $application->e_success_letter : null,
                "all_ar_uploaded" => $this->all_ar_uploaded,
                "status" => $application->currentStatus(),
                "status_description" => $this->status_description,
                'createdAt' => $application->created_at,
                'show_form' => $application->show_form,
                'submitted_by' => $application->submitted_by,
            ],

            "basic_details" => [
                'companyName' => $this->companyName,
                'companyEmailAddress' => $this->companyEmailAddress,
                'rcNumber' => $this->rcNumber,
                'registeredOfficeAddress' => $this->registeredOfficeAddress,
                'dateOfIncorporation' => $this->dateOfIncorporation,
                'placeOfIncorporation' => $this->placeOfIncorporation,
                'natureOfBusiness' => $this->natureOfBusiness,
                'companyTelephoneNumber' => $this->companyTelephoneNumber,
                'corporateWebsiteAddress' => $this->corporateWebsiteAddress,
                'authorisedShareCapitalCurrency' => $this->authorisedShareCapitalCurrency,
                'authorisedShareCapital' => $this->authorisedShareCapital,
            ],

            // "eSuccess" => $this->eSuccessLetterDetails($application),
            // "eMemberAgreement" => $this->eMemberAgreementDetails($application),

            'eSuccess' => [
                "companyName" => $application->eSuccess ? $application->eSuccess->name : $this->companyName,
                "registeredOfficeAddress" => $application->eSuccess ? $application->eSuccess->address : $this->registeredOfficeAddress,
                "applicant_name" => $application->eSuccess ? $application->eSuccess->rc_number : $application->applicant->full_name,
            ],

            'eMemberAgreement' => [
                "companyName" => $application->agreement ? $application->agreement->name : $this->companyName,
                "registeredOfficeAddress" => $application->agreement ? $application->agreement->address : $this->registeredOfficeAddress,
                "rcNumber" => $application->agreement ? $application->agreement->rc_number : $this->rcNumber,
                "date" => $application->agreement ? $application->agreement->date : now(),
            ],

            "primary_contact_details" => [
                'applicationPrimaryContactEmailAddress' => $this->applicationPrimaryContactEmailAddress,
                'applicationPrimaryContactName' => $this->applicationPrimaryContactName,
                'applicationPrimaryContactTelephone' => $this->applicationPrimaryContactTelephone,
            ],

            "bank_details" => [
                'bankDetailName' => $this->bankDetailName,
                'bankDetailAddress' => $this->bankDetailAddress,
                'bankDetailTelephone' => $this->bankDetailTelephone,
                'bankDetailMobileNumberOfAccountManager' => $this->bankDetailMobileNumberOfAccountManager,
                'bankDetailEmailAddressOfAccountManager' => $this->bankDetailEmailAddressOfAccountManager,
                'bankDetailTypeOfAccount' => $this->bankDetailTypeOfAccount,

                'bankDetailNameOne' => $this->bankDetailNameOne,
                'bankDetailAddressOne' => $this->bankDetailAddressOne,
                'bankDetailTelephoneOne' => $this->bankDetailTelephoneOne,
                'bankDetailMobileNumberOfAccountManagerOne' => $this->bankDetailMobileNumberOfAccountManagerOne,
                'bankDetailEmailAddressOfAccountManagerOne' => $this->bankDetailEmailAddressOfAccountManagerOne,
                'bankDetailTypeOfAccountOne' => $this->bankDetailTypeOfAccountOne,

                'bankDetailNameTwo' => $this->bankDetailNameTwo,
                'bankDetailAddressTwo' => $this->bankDetailAddressTwo,
                'bankDetailTelephoneTwo' => $this->bankDetailTelephoneTwo,
                'bankDetailMobileNumberOfAccountManagerTwo' => $this->bankDetailMobileNumberOfAccountManagerTwo,
                'bankDetailEmailAddressOfAccountManagerTwo' => $this->bankDetailEmailAddressOfAccountManagerTwo,
                'bankDetailTypeOfAccountTwo' => $this->bankDetailTypeOfAccountTwo,
            ],

            "bank_license_details" => [
                'bankingLicense' => $this->bankingLicense,
            ],

            "disciplinary_details" => [
                'companyDisciplinary' => $this->companyDisciplinary,
                'companyDisciplinaryOne' => $this->companyDisciplinaryOne,
                'companyDisciplinaryTwo' => $this->companyDisciplinaryTwo,
                'companyDisciplinaryThree' => $this->companyDisciplinaryThree,
                'companyDisciplinaryFour' => $this->companyDisciplinaryFour,

                'mdceoDisciplinary' => $this->mdceoDisciplinary,
                'mdceoDisciplinaryOne' => $this->mdceoDisciplinaryOne,
                'mdceoDisciplinaryTwo' => $this->mdceoDisciplinaryTwo,
                'mdceoDisciplinaryThree' => $this->mdceoDisciplinaryThree,
                'mdceoDisciplinaryFour' => $this->mdceoDisciplinaryFour,
                'mdceoDisciplinaryFive' => $this->mdceoDisciplinaryFive,
                'mdceoDisciplinarySix' => $this->mdceoDisciplinarySix,
                'mdceoDisciplinarySeven' => $this->mdceoDisciplinarySeven,
                'mdceoDisciplinaryEight' => $this->mdceoDisciplinaryEight,

                'treasureDisciplinary' => $this->treasureDisciplinary,
                'treasureDisciplinaryOne' => $this->treasureDisciplinaryOne,
                'treasureDisciplinaryTwo' => $this->treasureDisciplinaryTwo,
                'treasureDisciplinaryThree' => $this->treasureDisciplinaryThree,
                'treasureDisciplinaryFour' => $this->treasureDisciplinaryFour,
                'treasureDisciplinaryFive' => $this->treasureDisciplinaryFive,

                'chiefComplianceOfficerDisciplinary' => $this->chiefComplianceOfficerDisciplinary,
                'chiefComplianceOfficerDisciplinaryOne' => $this->chiefComplianceOfficerDisciplinaryOne,
                'chiefComplianceOfficerDisciplinaryTwo' => $this->chiefComplianceOfficerDisciplinaryTwo,
                'chiefComplianceOfficerDisciplinaryThree' => $this->chiefComplianceOfficerDisciplinaryThree,
                'chiefComplianceOfficerDisciplinaryFour' => $this->chiefComplianceOfficerDisciplinaryFour,
                'chiefComplianceOfficerDisciplinaryFive' => $this->chiefComplianceOfficerDisciplinaryFive,
            ],

            "custodian_details" => [
                'custodianInformationName' => $this->custodianInformationName,
                'custodianInformationAddress' => $this->custodianInformationAddress,
                'custodianInformationTelephone' => $this->custodianInformationTelephone,
                'custodianInformationMobileNumberOfContact' => $this->custodianInformationMobileNumberOfContact,
            ],

            "supporting_document" => [
                'CompanyOverview' => $this->CompanyOverview ? config('app.url') . '/storage/' . $this->CompanyOverview : null,
                'companyLogo' => $this->CompanyLogo ? config('app.url') . '/storage/' . $this->CompanyLogo : null,
                'certificateOfIncorporation' => $this->certificateOfIncorporation ? config('app.url') . '/storage/' . $this->certificateOfIncorporation : null,
                'memorandumAndArticlesOfAssociation' => $this->memorandumAndArticlesOfAssociation ? config('app.url') . '/storage/' . $this->memorandumAndArticlesOfAssociation : null,
                'particularsOfDirectors' => $this->particularsOfDirectors ? config('app.url') . '/storage/' . $this->particularsOfDirectors : null,
                'particularsOfShareholders' => $this->particularsOfShareholders ? config('app.url') . '/storage/' . $this->particularsOfShareholders : null,
                'evidenceOfRegistration' => $this->evidenceOfRegistration ? config('app.url') . '/storage/' . $this->evidenceOfRegistration : null,
                'detailedResumesOfSEC' => $this->detailedResumesOfSEC ? config('app.url') . '/storage/' . $this->detailedResumesOfSEC : null,
                'evidenceOfCompliance' => $this->evidenceOfCompliance ? config('app.url') . '/storage/' . $this->evidenceOfCompliance : null,
                'listOfAuthorisedRepresentatives' => $this->listOfAuthorisedRepresentatives ? config('app.url') . '/storage/' . $this->listOfAuthorisedRepresentatives : null,
                'latestFidelityBond' => $this->latestFidelityBond ? config('app.url') . '/storage/' . $this->latestFidelityBond : null,
                'mostRecentYearAuditedFinancialStatements' => $this->mostRecentYearAuditedFinancialStatements ? config('app.url') . '/storage/' . $this->mostRecentYearAuditedFinancialStatements : null,
                'evidenceFXAuthorisedDealershipLicence' => $this->evidenceFXAuthorisedDealershipLicence ? config('app.url') . '/storage/' . $this->evidenceFXAuthorisedDealershipLicence : null,
                'evidenceOfPaymentOfApplicationFee' => $this->evidenceOfPaymentOfApplicationFee ? config('app.url') . '/storage/' . $this->evidenceOfPaymentOfApplicationFee : null,
                'applicantDeclaration' => $this->applicantDeclaration ? config('app.url') . '/storage/' . $this->applicantDeclaration : null,
                'dulyCompletedApplicationForm' => $this->dulyCompletedApplicationForm ? config('app.url') . '/storage/' . $this->dulyCompletedApplicationForm : null,
                'companyProfile' => $this->companyProfile ? config('app.url') . '/storage/' . $this->companyProfile : null,
                'letterOfExpressionOfInterest' => $this->letterOfExpressionOfInterest ? config('app.url') . '/storage/' . $this->letterOfExpressionOfInterest : null,
                'resumeOfDealers' => $this->resumeOfDealers ? config('app.url') . '/storage/' . $this->resumeOfDealers : null,
                'evidenceOfMinimumShareholder' => $this->evidenceOfMinimumShareholder ? config('app.url') . '/storage/' . $this->evidenceOfMinimumShareholder : null,
                'confirmationOfTechnicalKnowledge' => $this->confirmationOfTechnicalKnowledge ? config('app.url') . '/storage/' . $this->confirmationOfTechnicalKnowledge : null,
                'thomsonReutersContractForm' => $this->thomsonReutersContractForm ? config('app.url') . '/storage/' . $this->thomsonReutersContractForm : null,
                'thomsonReutersCertificateOfIncorporation' => $this->thomsonReutersCertificateOfIncorporation ? config('app.url') . '/storage/' . $this->thomsonReutersCertificateOfIncorporation : null,
                'thomsonReutersMemorandumAndArticles' => $this->thomsonReutersMemorandumAndArticles ? config('app.url') . '/storage/' . $this->thomsonReutersMemorandumAndArticles : null,
                'thomsonReutersParticularsOfDirectors' => $this->thomsonReutersParticularsOfDirectors ? config('app.url') . '/storage/' . $this->thomsonReutersParticularsOfDirectors : null,
                'thomsonReutersEvidenceOfRegulatoryStatus' => $this->thomsonReutersEvidenceOfRegulatoryStatus ? config('app.url') . '/storage/' . $this->thomsonReutersEvidenceOfRegulatoryStatus : null,
            ],

            "required_documents" => $this->subRequiredDocuments($this->application_id),

            "payment_information" => $this->subPaymentInformation($this->application_id),

            "latest_evidence" => $this->subLatestEvidence($this->application_id),

            "payment_details" => $this->subPaymentReviewDetails($this->application_id),

            "fsd_review" => $application->status()->where('office', 'FSD')->get(),

            "mbg_review" => $application->status()->where('office', 'MBG')->get(),

            "meg_review" => $application->status()->where('office', 'MEG')->get(),

            "ars" => UserResource::collection(User::where('institution_id', $this->institution_id)->get()),

            "executed_membership_agreement" => ($this->meg_executed_membership_agreement) ? config('app.url') . '/storage/app/public/' . $this->meg_executed_membership_agreement : null,

            "e_success_letter" => ($this->e_success_letter) ? config('app.url') . '/storage/app/public/' . $this->e_success_letter : null,

            "completed" => $this->completed_at ? true : false,

            "createdAt" => $application->created_at,

            "reg_id" => $application->reg_id,

            'applicant_name' => $application->applicant->full_name,

            "ars" => $this->institutionUsers($application->institution_id),

            "report_table" => $this->report_table(),

            'proof_of_payment' => $application->proof_of_payment,

            'status_description' => $application->status_description,

            "download_link" => route('downloadReport', ['institution_application_report', $application->uuid]),

        ];
    }
}
