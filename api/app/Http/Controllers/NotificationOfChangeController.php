<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\NotificationOfChange;
use App\Models\NotificationOfChangeComment;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationOfChangeController extends Controller
{

    public function send(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:60'],
            'summary' => ['required', 'string', 'max:200'],
            'ar_authoriser_id' => ['required', 'integer', 'exists:users,id'],
            'regulatory_status' => ['required', 'string', 'in:yes,no'],
            'regulatory_approval' => ['required_if:regulatory_status,yes', 'file'],
            'confidentiality_level' => ['required', 'string', 'in:high,medium,low'],
            'attachment' => ['sometimes', 'file'],
        ]);

        if (!$user = User::where('id', $data['ar_authoriser_id'])->where('role_id', Role::ARAUTHORISER)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'AR is not an Authoriser');
        }

        $attachment = $request->hasFile('attachment') ? $request->file('attachment')->storePublicly('attachment', 'public') : null;
        $regulatory_approval = $request->hasFile('regulatory_approval') ? $request->file('regulatory_approval')->storePublicly('regulatory_approval', 'public') : null;

        $data['attachment'] = $attachment;
        $data['regulatory_approval'] = $regulatory_approval;
        $data['created_by'] = auth()->user()->id;
        $data['institution_id'] = auth()->user()->institution_id;

        $notify_request = NotificationOfChange::create($data);

        $user->notify(new InfoNotification(MailContents::arNotificationOfChangeMail($user, $notify_request->request_id), MailContents::arNotificationOfChangeSubject($notify_request->request_id, $notify_request->subject), [auth()->user()->email]));

        $logMessage = auth()->user()->email . ' initiated a notification of change ';

        logAction($user->email, 'New Notification Of Change', $logMessage, $request->ip());

        logAction(auth()->user()->email, 'New Notification Of Change', $logMessage, $request->ip());

        return successResponse('Notification Of Change sent to authoriser', []);

    }

    public function updateStatus(Request $request)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected'],
            'notification_id' => ['required', 'integer', 'exists:notification_of_changes,id'],
            'reason' => ['required_if:status,rejected', 'string'],
        ]);

        if (!$notify_request = NotificationOfChange::where('id', $data['notification_id'])->where('ar_authoriser_id', auth()->user()->id)->where('ar_status', NotificationOfChange::PENDING)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
        }

        if (!$user = User::where('id', $notify_request->created_by)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'AR is not an Authoriser');
        }

        $notify_request->ar_status = request('status');
        $notify_request->status_reason = request('reason');
        $notify_request->save();

        $logMessage = auth()->user()->email . ' updated  notification of change status ';

        logAction($user->email, 'Notification Of Change Status', $logMessage, $request->ip());
        logAction(auth()->user()->email, 'Notification Of Change Status', $logMessage, $request->ip());

        // status_reason

        $MEGs = Utility::getUsersByCategory(Role::MEG);
        if (count($MEGs)) {
            Notification::send($MEGs, new InfoNotification(MailContents::megNotificationOfChangeMail($user), MailContents::megNotificationOfChangeSubject()));
        }

        return successResponse('Notification Of Change status sent to authoriser', []);

    }

    public function arList()
    {
        $notify_requests = NotificationOfChange::where('institution_id', auth()->user()->institution_id)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $notify_requests);

    }
    public function list()
    {
        $notify_requests = NotificationOfChange::where('ar_status', NotificationOfChange::APPROVED)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $notify_requests);

    }

    public function comment(Request $request)
    {

        $data = $request->validate([
            'notification_id' => ['required', 'integer', 'exists:notification_of_changes,id'],
            'comment' => ['required', 'string'],
        ]);

        if (!$notify_request = NotificationOfChange::where('id', $data['notification_id'])->where('ar_status', NotificationOfChange::APPROVED)->where('meg_status', NotificationOfChange::PENDING)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
        }

        NotificationOfChangeComment::create([
            'notification_of_change_id' => $notify_request->id,
            'comments' => $data['comment'],
            'user_id' => auth()->user()->id,
        ]);

        $MEGs = Utility::getUsersByCategory(Role::MEG);
        if (auth()->user()->id == $notify_request->user->id) {

            if (count($MEGs)) {
                Notification::send($MEGs, new InfoNotification(MailContents::notificationOfChangeNewCommentMail(), MailContents::notificationOfChangeNewCommentSubject()));
            }

        } else {

            $user = $notify_request->user;
            $user_auth = $notify_request->authorizer;

            $user->notify(new InfoNotification(MailContents::arNotificationOfChangeMail($user, $notify_request->request_id), MailContents::arNotificationOfChangeSubject($notify_request->request_id, $notify_request->subject), [ ...$MEGs, $user_auth->email]));

        }

        return successResponse('Notification Of Change comment sent', []);

    }
    // public function megComment()
    // {
    //     $data = $request->validate([
    //         'notification_id' => ['required', 'integer', 'exists:notification_of_changes,id'],
    //         'comment' => ['required', 'string'],
    //     ]);

    //     if (!$notify_request = NotificationOfChange::where('id', $data['notification_id'])->where('ar_status', NotificationOfChange::APPROVED)->first()) {
    //         return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
    //     }

    //     NotificationOfChangeComment::create([
    //         'notification_of_change_id' => $notify_request->id,
    //         'comment' => $data['comment'],
    //         'user_id' => auth()->user()->id,
    //     ]);

    //     return successResponse('Notification Of Change status sent to authoriser', []);

    // }
    public function megUpdateStatus(Request $request)
    {

        $data = $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected'],
            'notification_id' => ['required', 'integer', 'exists:notification_of_changes,id'],
            'reason' => ['required_if:status,rejected', 'string'],
        ]);

        if (!$notify_request = NotificationOfChange::where('id', $data['notification_id'])->where('ar_authoriser_id', auth()->user()->id)->where('ar_status', NotificationOfChange::PENDING)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
        }

        if (!$user = User::where('id', $notify_request->created_by)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'AR is not an Authoriser');
        }

        $notify_request->ar_status = request('status');
        $notify_request->status_reason = request('reason');
        $notify_request->save();

        $logMessage = auth()->user()->email . ' updated  notification of change status ';

        logAction($user->email, 'Notification Of Change Status', $logMessage, $request->ip());

        logAction(auth()->user()->email, 'Notification Of Change Status', $logMessage, $request->ip());

        // status_reason

        $MEGs = Utility::getUsersByCategory(Role::MEG);
        if (count($MEGs)) {
            Notification::send($MEGs, new InfoNotification(MailContents::megNotificationOfChangeMail($user), MailContents::megNotificationOfChangeSubject()));
        }

        return successResponse('Notification Of Change status sent to authoriser', []);

    }

}
