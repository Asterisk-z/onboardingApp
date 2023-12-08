<?php

namespace App\Models\AR;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARDeactivationRequest extends Model
{
    use HasFactory;

    const PENDING = 'pending';
    const APPROVED = 'approved';
    const DECLINED = 'declined';

    const REQUEST_TYPE_ACTIVATE = 'activate';
    const REQUEST_TYPE_DEACTIVATE = 'deactivate';


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

}
