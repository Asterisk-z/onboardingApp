<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Complaint;
use App\Models\ComplaintType;
use App\Models\Role;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'sometimes|in:PENDING,WORK_IN_PROGRESS,CLOSED',
        ]);

        $status = $request->input('status');
        $user = $request->user();

        switch ($status) {
            case 'PENDING':
                $complaints = $user->complaints()->where('status', 'PENDING')->latest()->get();
                break;
            case 'WORK_IN_PROGRESS':
                $complaints = $user->complaints()->where('status', 'WORK_IN_PROGRESS')->latest()->get();
                break;
            case 'CLOSED':
                $complaints = $user->complaints()->where('status', 'CLOSED')->latest()->get();
                break;
            default:
                $complaints = $user->complaints()->latest()->get();
                break;
        }

        return successResponse('Here you go.', $complaints);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function allComplaints(Request $request)
    {
        $request->validate([
            'status' => 'sometimes|in:PENDING,WORK_IN_PROGRESS,CLOSED',
        ]);

        $status = $request->input('status');

        switch ($status) {
            case 'PENDING':
                $complaints = Complaint::where('status', 'PENDING')->latest()->get();
                break;
            case 'WORK_IN_PROGRESS':
                $complaints = Complaint::where('status', 'WORK_IN_PROGRESS')->latest()->get();
                break;
            case 'CLOSED':
                $complaints = Complaint::where('status', 'CLOSED')->latest()->get();
                break;
            default:
                $complaints = Complaint::latest()->get();
                break;
        }

        return successResponse('Here you go.', $complaints);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "complaint_type" => "required|exists:complaint_types,id",
            "body" => "required|string",
            "document" => "nullable|mimes:jpeg,png,jpg,pdf|max:5048",
        ]);

        $user = $request->user();

        $user->complaints()->create([
            'document' => $request->hasFile('document') ? $request->file('document')->storePublicly('complaint', 'public') : null,
            'body' => $request->input('body'),
            'complaint_type_id' => $request->input('complaint_type'),
        ]);

        $complaint_type = ComplaintType::find($request->input('complaint_type'));

        //

        if ($request->input('complaint_type') === '1') {
            $ccMEGs = Utility::getUsersEmailByCategory(Role::MEG);
            $helpDeskEmail = Utility::getUsersByCategory(Role::HELPDESK);

            Notification::send(
                $helpDeskEmail,
                new InfoNotification(MailContents::complaintSubmitMail($user->first_name . " " . $user->last_name, $user->institution->name ?? null, $request->input('body')), MailContents::complaintSubmitSubject($complaint_type ? $complaint_type->name : ""), $ccMEGs)
            );
        } else {
            $MEGs = Utility::getUsersByCategory(Role::MEG);
            if (count($MEGs)) {
                Notification::send($MEGs, new InfoNotification(MailContents::complaintSubmitMail($user->first_name . " " . $user->last_name, $user->institution->name ?? null, $request->input('body')), MailContents::complaintSubmitSubject($complaint_type ? $complaint_type->name : "")));
            }
        }

        logAction($request->user()->email, 'New Complaint', 'Logged a new complaint', $request->ip());
        return successResponse('Your complaint has been submitted.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function feedback(Request $request)
    {
        $request->validate([
            "complaint_id" => "required|exists:complaints,id",
            "comment" => "required|string",
            "status" => "nullable|in:WORK_IN_PROGRESS,CLOSED",
        ]);

        $user = $request->user();

        $comment = $user->comments()->create([
            'complaint_id' => $request->input('complaint_id'),
            'comment' => $request->input('comment'),
        ]);

        $comment->complaint()->update([
            "status" => $request->input('status') ?? "WORK_IN_PROGRESS",
        ]);

        $comment->complaint->user->notify(new InfoNotification(MailContents::complaintCommentMail($request->input('comment'), $request->input('status')), MailContents::complaintCommentSubject()));
        logAction($request->user()->email, 'Complaint Feedback', 'Made comment on a complaint', $request->ip());
        return successResponse('Your comment has been submitted.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            "complaint_id" => "required|exists:complaints,id",
            "status" => "required|in:WORK_IN_PROGRESS,CLOSED",
        ]);

        $complaint = Complaint::find($request->input('complaint_id'));

        $complaint->update([
            "status" => $request->input('status'),
        ]);

        $complaint->user->notify(new InfoNotification(MailContents::complaintStatusMail($request->input('status')), MailContents::complaintStatusSubject()));
        logAction($request->user()->email, 'Change Complaint status', 'Change Complaint status', $request->ip());
        return successResponse('Status changed successfully.');
    }
}
