<?php

namespace App\Models\AR;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARDeactivationRequest extends Model
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

}
