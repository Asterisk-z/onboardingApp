<?php

namespace App\Models\AR;

use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARTransferRequest extends Model
{
    use HasFactory;

    public function ar()
    {
        return $this->belongsTo(User::class, 'ar_user_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'authoriser_id');
    }

    public function newInstitution()
    {
        return $this->belongsTo(Institution::class, 'new_institution_id');
    }


}

