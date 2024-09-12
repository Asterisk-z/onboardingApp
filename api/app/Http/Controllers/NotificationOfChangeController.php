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

        $attachment = $request->hasFile('attachment') ? $request->file('attachment')->storePublicly('change_attachment', 'public') : null;
        $regulatory_approval = $request->hasFile('regulatory_approval') ? $request->file('regulatory_approval')->storePublicly('change_regulatory_approval', 'public') : null;

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

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);

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
            'notification_id' => ['required', 'integer', 'exists:notification_of_changes,id'],
            'status' => ['required', 'string', 'in:approved,rejected'],
            'reason' => ['required_if:status,rejected', 'string'],
            'subject' => ['required_if:status,approved', 'string'],
            'summary' => ['required_if:status,approved', 'string'],
            'list_of_stakeholders' => ['required_if:status,approved', 'array'],
            'list_of_stakeholders.*' => ['required_if:status,approved', 'exists:users,id',
                function ($attribute, $value, $fail) {
                    if (User::where('id', $value)->where('role_id', '!=', Role::STAKEHOLDER)->exists()) {
                        $fail('Select Only Stakeholders.');
                    }
                }],
            'document' => ['file'],
        ]);

        if (!$notify_request = NotificationOfChange::where('id', $data['notification_id'])->where('ar_status', NotificationOfChange::APPROVED)->where('meg_status', NotificationOfChange::PENDING)->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
        }

        if (request('status') == 'rejected') {
            $notify_request->status_reason = request('reason');
        }

        if (request('status') == 'approved') {
            $notify_request->meg_subject = request('subject');
            $notify_request->meg_summary = request('summary');
            $notify_request->meg_document = request()->hasFile('document') ? request()->file('document')->storePublicly('change_document', 'public') : null;
            $notify_request->stakeholders = request('list_of_stakeholders');
        }

        $notify_request->meg_status = request('status');

        $notify_request->save();

        $user = $notify_request->user;
        $authorizer = $notify_request->authorizer;

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        if (request('status') == 'rejected') {
            $logMessage = auth()->user()->email . ' rejected  notification of change  ';
            $user->notify(new InfoNotification(MailContents::arNotificationOfChangeRejectMail($notify_request->request_id, request('reason')), MailContents::arNotificationOfChangeRejectSubject($notify_request->request_id, $notify_request->subject), [ ...$MEGs, $authorizer->email]));
        }

        if (request('status') == 'approved') {
            $logMessage = auth()->user()->email . ' approved  notification of change ';
            $user->notify(new InfoNotification(MailContents::arNotificationOfChangeAcceptMail($notify_request->request_id), MailContents::arNotificationOfChangeAcceptSubject($notify_request->request_id, $notify_request->subject), [ ...$MEGs, $authorizer->email]));

            $list_of_stakeholders = User::whereIn('id', request('list_of_stakeholders'))->get();

            if (count($list_of_stakeholders) > 0) {

                // $path = config('app.url') . '/storage/' . $notify_request->meg_document;
                if ($notify_request->meg_document) {
                    $path = config('app.url') . '' . config('app.storage_path') . '' . $notify_request->meg_document;
                    $attachment = [
                        'saved_path' => $path,
                        'name' => 'notification-of-change-document' . pathinfo($path, PATHINFO_EXTENSION),
                    ];

                } else {
                    $attachment = [];

                }

                Notification::send($list_of_stakeholders, new InfoNotification(request('summary'), request('subject'), [], $attachment));
            }
        }

        logAction($user->email, 'Notification Of Change Update', $logMessage, $request->ip());

        logAction(auth()->user()->email, 'Notification Of Change Update', $logMessage, $request->ip());

        return successResponse('Notification Of Change status updated successfully', []);

    }

}
