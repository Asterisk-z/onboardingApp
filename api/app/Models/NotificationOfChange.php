<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationOfChange extends Model
{

    use HasFactory;
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    protected $guarded = ['id'];
    protected $appends = ['request_id', 'is_ar_pending', 'is_ar_approved'];

    public function getRequestIdAttribute()
    {
        return 'FMDQX/NTRQ-' . str_pad($this->id, 4, "0", STR_PAD_LEFT) . date("Ymd", strtotime($this->created_at));
    }

    public function getIsArPendingAttribute()
    {
        return $this->ar_status == 'pending';
    }

    public function getIsArApprovedAttribute()
    {
        return $this->ar_status == 'approved';
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "subject" => $this->subject,
            "summary" => $this->summary,
            "requester" => $this->user,
            "requestId" => $this->request_id,
            "authorizer" => $this->authorizer,
            "arStatus" => $this->ar_status,
            "isArPending" => $this->is_ar_pending,
            "isArApproved" => $this->is_ar_approved,
            "attachment" => $this->attachment ? config('app.url') . '/storage/app/public/' . $this->attachment : null,
            // "meg_document" => $this->meg_document ? config('app.url') .'/storage/app/public/'.$this->meg_document : null,
            "status" => $this->meg_status,
            // "meg_subject" => $this->meg_subject,
            // "meg_summary" => $this->meg_summary,
            "regulatoryApproval" => $this->regulatory_approval ? config('app.url') . '/storage/app/public/' . $this->regulatory_approval : null,
            "confidentialityLevel" => $this->confidentiality_level,
            "institution" => $this->institution_id,
            "regulatoryStatus" => $this->regulatory_status,
            "arStatusReason" => $this->status_reason ? $this->status_reason : '',
            "comment" => $this->comments,
            'createdAt' => $this->created_at,
        ];
    }

    public function comments()
    {
        return $this->hasMany(NotificationOfChangeComment::class, 'notification_of_change_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function authorizer()
    {
        return $this->hasOne(User::class, 'id', 'ar_authoriser_id');
    }

}
