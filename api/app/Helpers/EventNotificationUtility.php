<?php
namespace App\Helpers;

use App\Models\Education\Event;
use App\Models\Education\EventRegistration;
use App\Models\Role;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InfoNotification;

class EventNotificationUtility
{



    public static function paymentStatusUpdated(EventRegistration $eventReg)
    {
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $FSDs = Utility::getUsersEmailByCategory(Role::FSD);
        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);

        $CCs = array_merge($MEGs, $FSDs, $MBGs);

        $message = null;

        if ($eventReg->status == EventRegistration::STATUS_APPROVED) {
            $message = EventMailContents::paymentApprovedARBody($eventReg->event->name, $eventReg->admin_remark);
            $subject = EventMailContents::paymentApprovedARSubject($eventReg->event->name);

        } elseif ($eventReg->status == EventRegistration::STATUS_DECLINED) {
            $message = EventMailContents::paymentDeclinedARBody($eventReg->event->name, $eventReg->admin_remark);
            $subject = EventMailContents::paymentDeclinedARSubject($eventReg->event->name);
        }

        if ($message) {
            self::sendNotification($message, $subject, $eventReg->user, $CCs);
        }

    }

    private static function sendNotification($subject, $message, $users, $CCs = [])
    {
        Notification::send($users, new InfoNotification($message, $subject, $CCs));
    }


    public static function eventUpdated(Event $event)
    {

        $to = null;
        $CCs = [];

        $eventName = $event->name;
        $message = EventMailContents::eventUpdatedBody($eventName);
        $subject = EventMailContents::eventUpdatedSubject($eventName);

        $registeredUsers = $event->getRegisteredUsers();

        if ($registeredUsers) {
            // email registered AR and copy MEG
            $to = $registeredUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs))
                $to = $MEGs;
        }


        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }
    }

    public static function eventDeleted($registeredUsers, string $eventName)
    {

        $to = null;
        $CCs = [];

        $message = EventMailContents::eventDeletedBody($eventName);
        $subject = EventMailContents::eventDeletedSubject($eventName);



        if ($registeredUsers) {
            // email registered AR and copy MEG
            $to = $registeredUsers;
            $CCs = Utility::getUsersEmailByCategory(Role::MEG);
        } else {
            // Email MEGs
            $MEGs = Utility::getUsersByCategory(Role::MEG);

            if (count($MEGs))
                $to = $MEGs;
        }


        if ($to) {
            self::sendNotification($message, $subject, $to, $CCs);
        }

    }


}
