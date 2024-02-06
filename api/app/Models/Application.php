<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    const AWAITINGAPPROVAL = 'Awaiting Approval';

    const statuses = [
        'PEN' => 'PENDING',
        'FDP' => 'FSD DECLINED PAYMENT',
        'FAP' => 'FSD APPROVED PAYMENT',
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
        'MAFR' => 'FSD REVIEW APPROVED BY MBG',
        'MDD' => "MEG DECLINED DOCUMENT",
        'MDMR' => "MEG DECLINED MBG REVIEW",
        'MAMR' => "MEG APPROVED MBG REVIEW",
        'M2DMR' => "MEG2 DECLINED MEG REVIEW",
        'M2AMR' => "MEG2 APPROVED MEG REVIEW",
        'AEM' => "MEMBERSHIP AGREEMENT EXECUTED BY APPLICANT",
        'MEM' => "MEMBERSHIP AGREEMENT EXECUTED BY MEG",
    ];

    const office = [
        'AP' => 'APPLICANT',
        'MBG' => 'MBG',
        'MEG' => 'MEG',
        'MEG2' => 'MEG2',
        'FSD' => 'FSD',
        'BL' => 'BACKLOG',
    ];

    protected $appends = ['status_description'];

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

    public function uploads()
    {
        return $this->hasMany(ApplicationFieldUpload::class, 'application_id');
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
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function getStatusDescriptionAttribute()
    {
        $status = Status::find($this->status);

        return $status->status;
    }
}
