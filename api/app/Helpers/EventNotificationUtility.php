<?php

namespace App\Helpers;

use App\Jobs\EventCompletionJob;
use App\Models\Education\Event;
use App\Models\Education\EventRegistration;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class EventNotificationUtility
{

    public static function certificate(EventRegistration $eventReg)
    {

        $attachment = [
            [
                'saved_path' => config('app.url') . '' . config('app.storage_path') . 'event_certs/' . $eventReg->certificate_path,
                'name' => Str::slug($eventReg->event->name) . '-certificate.pdf',
            ],
        ];
        if ($eventReg->event->presentation) {
            array_push($attachment, [
                'saved_path' => config('app.url') . '' . config('app.storage_path') . '' . $eventReg->event->presentation,
                'name' => Str::slug($eventReg->event->name) . '-presentation.pdf',
            ]);
        }

        $message = EventMailContents::certificateARBody($eventReg->event->name, $attachment);
        $subject = EventMailContents::certificateARSubject($eventReg->event->name);

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);

        $emailData = [
            'name' => $eventReg->user->first_name,
            'subject' => $subject,
            'content' => $message,
        ];

        EventCompletionJob::dispatch($eventReg, $emailData, $MEGs, $attachment);
    }

    public static function pendingPaymentEventRegistration(EventRegistration $eventReg)
    {
        $FSDs = Utility::getUsersByCategory(Role::FSD);
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);

        $CCs = array_merge($MEGs, $MBGs);

        $message = EventMailContents::pendingPaymentForEventRegistrationBody($eventReg->event->name);
        $subject = EventMailContents::pendingPaymentForEventRegistrationSubject($eventReg->event->name);

        self::sendNotification($message, $subject, $FSDs, $CCs);
    }

    public static function paymentStatusUpdated(EventRegistration $eventReg)
    {
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $FSDs = Utility::getUsersEmailByCategory(Role::FSD);
        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);

        $CCs = array_merge($MEGs, $FSDs, $MBGs);

        $message = null;

        if ($eventReg->status == EventRegistration::STATUS_APPROVED) {
            $message = EventMailContents::paymentApprovedARBody($eventReg->event->name);
            $subject = EventMailContents::paymentApprovedARSubject($eventReg->event->name);
        } elseif ($eventReg->status == EventRegistration::STATUS_DECLINED) {
            $message = EventMailContents::paymentDeclinedARBody($eventReg->event->name, $eventReg->admin_remark);
            $subject = EventMailContents::paymentDeclinedARSubject($eventReg->event->name);
        }

        if ($message) {
            self::sendNotification($message, $subject, $eventReg->user, $CCs);
        }
    }

    private static function sendNotification($message, $subject, $users, $CCs = [])
    {
        Notification::send($users, new InfoNotification($message, $subject, $CCs));
    }

    public static function eventUpdated(Event $event, $toUsers = [])
    {

        $CCs = [];
        $to = [];

        $eventName = $event->name;
        $message = EventMailContents::eventUpdatedBody($eventName);
        $subject = EventMailContents::eventUpdatedSubject($eventName);

        $newlyInvitedUsers = $event->newlyInvitedUsers();

        $sendto = $toUsers ?? $newlyInvitedUsers;

        if ($sendto) {
            // email registered AR and copy MEG
            $to = $sendto;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs)) {
                $to = $MEGs;
            }

        }

        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }

    public static function eventAdded(Event $event)
    {
        $to = null;
        $CCs = [];

        $eventName = $event->name;
        $message = EventMailContents::eventAddedBody($event);
        $subject = EventMailContents::eventAddedSubject($eventName);

        $invitedUsers = $event->newlyInvitedUsers();

        if ($invitedUsers) {
            // email registered AR and copy MEG
            $to = $invitedUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs)) {
                $to = $MEGs;
            }

        }

        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }

    public static function eventUninvited($to, $eventName)
    {
        $message = EventMailContents::eventUninvitedBody($eventName);
        $subject = EventMailContents::eventUninvitedSubject($eventName);

        if ($to) {
            self::sendNotification($message, $subject, $to);
        }
    }

    public static function reminderNotification(Event $event)
    {
        $to = null;
        $CCs = [];

        $eventName = $event->name;
        $message = EventMailContents::reminderBody($event);
        $subject = EventMailContents::reminderSubject($eventName);

        $registeredUsers = $event->getRegisteredUsers();

        if ($registeredUsers) {
            // email registered AR and copy MEG
            $to = $registeredUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs)) {
                $to = $MEGs;
            }

        }

        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }

    public static function inviteNotification(Event $event)
    {
        $to = null;
        $CCs = [];

        $eventName = $event->name;
        $message = EventMailContents::invitedBody($event);
        $subject = EventMailContents::invitedSubject($eventName);

        $invitedUsers = $event->newlyInvitedUsers();

        if ($invitedUsers) {
            // email registered AR and copy MEG
            $to = $invitedUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs)) {
                $to = $MEGs;
            }

        }

        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }

    public static function eventDeleted($registeredUsers, Event $event, string $reason)
    {
        $to = null;
        $CCs = [];

        $eventName = $event->name;
        $eventDate = $event->date;

        $message = EventMailContents::eventDeletedBody($eventName, $eventDate, $reason);
        $subject = EventMailContents::eventDeletedSubject($eventName);

        if ($registeredUsers) {
            // email registered AR and copy MEG
            $to = $registeredUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs)) {
                $to = $MEGs;
            }

        }

        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }
}
