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
            'image_url' => $this->image ? config('app.url') . '/storage/app/public/' . $this->image : null, // Adjust the path based on your storage setup
            'is_event_completed' => $this->is_event_completed,
            'is_sent_for_signing' => $this->is_sent_for_signing,
            'cert_signature' => $this->cert_signature ? config('app.url') . '/storage/app/public/' . $this->cert_signature : null,
            'signed_by' => $this->signed_by,
        ];
    }

    //  if no user, empty array is returned.
    public function getRegisteredUsers()
    {
        $userIds = $this->registrations->pluck('user_id');
        $users = User::whereIn('id', $userIds)->get();

        if (count($users)) {
            return $users;
        }

        return [];
    }

    public function newlyInvitedUsers()
    {
        $positionIds = $this->invitePosition->pluck('position_id');
        $users = User::whereIn('position_id', $positionIds)->get();

        if (count($users)) {
            return $users;
        }

        return [];
    }

}
