<?php

namespace App\Models\Education;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $with = ['registeredRemainderDates', 'unregisteredRemainderDates', 'invitePosition'];
    protected $withCount = ['registrations'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registeredRemainderDates()
    {
        return $this->hasMany(EventNotificationDates::class)
            ->where('type', 'Registered');
    }

    public function unregisteredRemainderDates()
    {
        return $this->hasMany(EventNotificationDates::class)
            ->where('type', 'Unregistered');
    }

    public function invitePosition()
    {
        return $this->hasMany(EventInvitePosition::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function getBasicData()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'is_annual' => $this->is_annual,
            'fee' => $this->fee,
        ];
    }
}
