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
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getCertificateFullPath($filePath)
    {
        return storage_path('app/public/event_certs') . "/" . $filePath;
    }
}
