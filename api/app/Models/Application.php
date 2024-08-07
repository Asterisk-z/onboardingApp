<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    const AWAITINGAPPROVAL = 'Awaiting Approval';

    const statuses = [
        'PEN' => 'PENDING',
        'FDP' => 'FSD DECLINED PAYMENT',
        'FAP' => 'FSD CONFIRMED PAYMENT',
        'AS' => 'APPLICATION SUBMITTED',
        'MPC' => 'MEMBERSHIP APPLICATION COMPLETED',
        'ACS' => 'APPLICATION AWAITING CONCESSION',
        'CG' => 'CONCESSION GRANTED',
        'CNG' => 'CONCESSION NOT GRANTED',
        'AFR' => 'AWAITING FSD REVIEW',
        'APU' => 'AWAITING PROOF OF PAYMENT UPLOAD',
        'PPU' => 'PROOF OF PAYMENT UPLOADED',
        'ABR' => 'AWAITING MBG REVIEW',
        'AER' => 'AWAITING MEG REVIEW',
        'RJ' => 'APPLICATION REJECTED',
        'MRF' => 'MBG REJECTED FSD REVIEW',
        'MDP' => 'MBG DECLINED PAYMENT',
        'MDFR' => 'FSD REVIEW DECLINED BY MBG',
        'MAFR' => 'MBG APPROVED PAYMENT',
        'MDD' => "MEG DECLINED DOCUMENT",
        'MDMR' => "MEG DECLINED MBG REVIEW",
        'MAMR' => "MEG APPROVED MBG REVIEW",
        'M2DMR' => "MEG2 DECLINED MEG REVIEW",
        'M2AMR' => "MEG2 APPROVED MEG REVIEW",
        'M2AEL' => "MEG2 APPROVED E-SUCCESS LETTER",
        'MSMA' => "MEG SENT MEMBERSHIP AGREEMENT",
        'AEM' => "MEMBERSHIP AGREEMENT EXECUTED BY APPLICANT",
        'AUARA' => "APPLICANT UPLOADED ALL REQUIRED ARS",
        'MEM' => "MEMBERSHIP AGREEMENT EXECUTED BY MEG",
        'ARD' => "APPLICANT REUPLOADED DOCUMENT",
        'MAA' => "MEG APPROVE APPLICATION",
        'RMA' => "REQUIRE MEG APPROVAL",
        'AD' => "ADMIN",
        "TER" => "TERMINATED",
        "ACT" => "ACTIVE",
    ];

    const office = [
        'AP' => 'APPLICANT',
        'MBG' => 'MBG',
        'MEG' => 'MEG',
        'MEG2' => 'MEG2',
        'FSD' => 'FSD',
        'BL' => 'BACKLOG',
    ];

    const type = [
        'APP' => 'application',
        'CON' => 'conversion',
        'ADD' => 'addition',
    ];

    const typeStatus = [
        'ASP' => 'INPROGRESS',
        'ASC' => 'COMPLETED',
        'ASN' => 'CANCELED',
    ];

    protected $appends = ['status_description', 'reg_id'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'institution_id' => $this->institution_id,
            'membership_category' => $this->membershipCategory,
            'status_description' => $this->status_description,
            'concession_stage' => $this->concession_stage,
            'proof_of_payment' => $this->proof_of_payment,
            'meg2_review_stage' => $this->meg2_review_stage,
            'is_applicant_executed_membership_agreement' => $this->is_applicant_executed_membership_agreement,
            'membership_agreement' => $this->membership_agreement,
            "member_agreement" => ($this->membership_agreement) ? config('app.url') . '/storage/app/public/' . $this->membership_agreement : null,
            'has_member_agreement' => $this->agreement ? true : false,
            'has_e_success' => $this->eSuccess ? true : false,
            'member_agreement_link' => $this->agreement ? route('agreementPreview', $this->uuid) : null,
            "executed_membership_agreement" => ($this->meg_executed_membership_agreement) ? config('app.url') . '/storage/app/public/' . $this->meg_executed_membership_agreement : null,
            'e_success_letter' => ($this->e_success_letter) ? config('app.url') . '/storage/app/public/' . $this->e_success_letter : null,
            'completed_at' => $this->completed_at,
            'disclosure_stage' => $this->disclosure_stage,
            'step' => $this->step,
            'all_ar_uploaded' => $this->all_ar_uploaded,
            'created_at' => $this->created_at,
            'reg_id' => $this->reg_id,
            'applicant_email' => $this->applicant ? $this->applicant->email : "",
            'applicant_full_name' => $this->applicant ? $this->applicant->full_name : "",
        ];
    }

    public function status()
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    public function invoice()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    public function proof_of_payment()
    {
        return $this->morphMany(ProofOfPayment::class, 'proofable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function membershipCategory()
    {
        return $this->belongsTo(MembershipCategory::class, 'membership_category_id');
    }

    public function uploads()
    {
        return $this->hasMany(ApplicationFieldUpload::class, 'application_id');
    }

    public function agreement()
    {
        return $this->hasOne(MemberAgreement::class, 'application_id');
    }
    public function eSuccess()
    {
        return $this->hasOne(MemberESuccessLetter::class, 'application_id');
    }

    public function currentStatus()
    {
        $status = Status::find($this->status);

        return $status ? $status->status : 'pending';
    }

    public function statusModel()
    {
        $status = Status::find($this->status);

        return $status;
    }

    public function applicant()
    {
        return $this->hasOne(User::class, 'id', 'submitted_by');
    }

    public function getStatusDescriptionAttribute()
    {
        $status = Status::find($this->status);

        return $status->status;
    }

    public function getRegIdAttribute()
    {

        return 'FMDQX/APR-' . str_pad($this->id, 4, "0", STR_PAD_LEFT) . date("Ymd", strtotime($this->created_at));

    }

    public function createUuid()
    {
        $uuid = Str::uuid()->toString();
        return $this->checkUuid($uuid);
    }

    public function checkUuid($uuid)
    {
        if (!Application::where('uuid', $uuid)->exists()) {
            return $uuid;
        }
        $this->createUuid();
    }

}
