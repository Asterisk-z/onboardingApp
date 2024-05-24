<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakeHolderAccessRequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['is_pending'];

    const APPROVED = 'approved';
    const DECLINED = 'declined';
    const PENDING = 'pending';

    public function getIsPendingAttribute()
    {
        return $this->status == 'pending';
    }

}
