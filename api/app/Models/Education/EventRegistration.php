<?php

namespace App\Models\Education;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['user'];

    const STATUS_DECLINED = "Declined";
    const STATUS_APPROVED = "Registered";
    const STATUS_PENDING = "Pending";

    public function event()
    {
        return $this->belongsTo(Event::class)->where('is_del', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
