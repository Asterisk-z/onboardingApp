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
        'ACS' => 'AWAITING CONCESSION STAGE',
        'AFR' => 'AWAITING FSD REVIEW',
        'APU' => 'AWAITING PROOF OF PAYMENT UPLOAD',
        'ABR' => 'AWAITING MBG REVIEW',
        'AER' => 'AWAITING MEG REVIEW',
        'RJ'  => 'REJECTED',
        'MRF' => 'MBG REJECTED FSD REVIEW',
    ];

    const office = [
        'AP' => 'APPLICANT',
        'MBG' => 'MBG',
        'MEG' => 'MEG',
        'FSD' => 'FSD',
        'BL'  => 'BACKLOG'
    ];

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

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function uploads() {
        return $this->hasMany(ApplicationFieldUpload::class, 'application_id');
    }

    public function currentStatus(){
        $status = Status::find($this->status); 

        return $status ? $status->status : 'pending';
    }

    public function statusModel(){
        $status = Status::find($this->status); 

        return $status;
    }

    public function applicant(){
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
