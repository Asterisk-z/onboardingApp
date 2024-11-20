<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArCreationRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['ars'];
    protected $appends = ['is_mbg_pending', 'is_mbg_approved', 'is_pending', 'is_msg_pending'];

    public function toArray()
    {
        return [
            "id" => $this->id,
            "mbg_status" => $this->mbg_status,
            "msg_status" => $this->msg_status,
            "is_mbg_pending" => $this->is_mbg_pending,
            "is_pending" => $this->is_pending,
            "is_mbg_approved" => $this->is_mbg_approved,
            "is_msg_pending" => $this->is_msg_pending,
            "status" => $this->status,
            "createdAt" => $this->created_at,
            "system" => $this->system,
            "system_name" => $this->system->name,
            "ars" => $this->ars,
            "institution_name" => $this->user->institution->name,
            "category_name" => $this->user->category->name,
        ];
    }

    public function system()
    {
        return $this->belongsTo(FmdqSystems::class, 'system_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function ars()
    {
        return $this->hasMany(ArsToBeCreatedOnSystem::class);
    }

    public function getIsMbgPendingAttribute()
    {
        return $this->mbg_status == 'Pending';
    }

    public function getIsPendingAttribute()
    {
        return $this->status == 'Pending';
    }
    public function getIsMbgApprovedAttribute()
    {
        return $this->mbg_status == 'Approved';
    }

    public function getIsMsgPendingAttribute()
    {
        return $this->msg_status == 'Pending';
    }
}
