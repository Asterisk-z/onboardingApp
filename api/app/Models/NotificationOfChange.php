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
    protected $appends = ['request_id'];

    public function getRequestIdAttribute()
    {
        return 'FMDQX/NTRQ-' . str_pad($this->id, 4, "0", STR_PAD_LEFT) . date("Ymd", strtotime($this->created_at));
    }
}
