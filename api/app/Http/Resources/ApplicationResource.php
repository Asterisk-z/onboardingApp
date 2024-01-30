<?php

namespace App\Http\Resources;

use App\Models\Application;
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
                "application_id" => $this->application_id,
                "institution_id" => $this->institution_id,
                "concession_stage" => $this->concession_stage,
                "amount_received_by_fsd" => $this->amount_received_by_fsd,
                "mbg_review_stage" => $this->mbg_review_stage,
                "meg_review_stage" => $this->meg_review_stage,
                "meg2_review_stage" => $this->meg2_review_stage,
                "fsd_review_stage" => $this->fsd_review_stage,
                "category_id" => $this->category_id,
                "category_name" => $this->category_name,
                "completed_at" => $this->completed_at,
                "is_applicant_executed_membership_agreement" => $this->is_applicant_executed_membership_agreement,
                "all_ar_uploaded" => $this->all_ar_uploaded,
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
                'CompanyOverview' => $this->CompanyOverview,
                'certificateOfIncorporation' => $this->certificateOfIncorporation,
                'memorandumAndArticlesOfAssociation' => $this->memorandumAndArticlesOfAssociation,
                'particularsOfDirectors' => $this->particularsOfDirectors,
                'particularsOfShareholders' => $this->particularsOfShareholders,
                'evidenceOfRegistration' => $this->evidenceOfRegistration,
                'detailedResumesOfSEC' => $this->detailedResumesOfSEC,
                'evidenceOfCompliance' => $this->evidenceOfCompliance,
                'listOfAuthorisedRepresentatives' => $this->listOfAuthorisedRepresentatives,
                'latestFidelityBond' => $this->latestFidelityBond,
                'mostRecentYearAuditedFinancialStatements' => $this->mostRecentYearAuditedFinancialStatements,
                'evidenceFXAuthorisedDealershipLicence' => $this->evidenceFXAuthorisedDealershipLicence,
                'evidenceOfPaymentOfApplicationFee' => $this->evidenceOfPaymentOfApplicationFee,
                'applicantDeclaration' => $this->applicantDeclaration,
                'dulyCompletedApplicationForm' => $this->dulyCompletedApplicationForm,
                'companyProfile' => $this->companyProfile,
                'letterOfExpressionOfInterest' => $this->letterOfExpressionOfInterest,
                'resumeOfDealers' => $this->resumeOfDealers,
                'evidenceOfMinimumShareholder' => $this->evidenceOfMinimumShareholder,
                'confirmationOfTechnicalKnowledge' => $this->confirmationOfTechnicalKnowledge,
                'thomsonReutersContractForm' => $this->thomsonReutersContractForm,
                'thomsonReutersCertificateOfIncorporation' => $this->thomsonReutersCertificateOfIncorporation,
                'thomsonReutersMemorandumAndArticles' => $this->thomsonReutersMemorandumAndArticles,
                'thomsonReutersParticularsOfDirectors' => $this->thomsonReutersParticularsOfDirectors,
                'thomsonReutersEvidenceOfRegulatoryStatus' => $this->thomsonReutersEvidenceOfRegulatoryStatus,
            ],

            "payment_information" => $this->subPaymentInformation($this->application_id),

            "latest_evidence" => $this->subLatestEvidence($this->application_id),

            "payment_details" => $this->subPaymentReviewDetails($this->application_id),

            "fsd_review" => $application->status()->where('office', 'FSD')->get(),

            "mbg_review" => $application->status()->where('office', 'MBG')->get(),

            "meg_review" => $application->status()->where('office', 'MEG')->get(),

        ];
    }
}
