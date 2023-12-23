<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Role;
use App\Models\Sanction;
use App\Models\User;
use App\Notifications\InfoNotification;
use App\Rules\ValidArRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SanctionsController extends Controller
{
    //
    public function index()
    {
        $sanctions = Sanction::orderBy('created_at', 'DESC')->get();

        return successResponse('Successful', $sanctions);
    }

    //
    public function store(Request $request): JsonResponse
    {
        //
        $request->validate([
            "ar" => ["required", "string", new ValidArRole],
            "ar_summary" => "required|string",
            "sanction_summary" => "required|string",
            "evidence" => "required|mimes:pdf",
        ]);

        $attachment = [];

        if ($request->hasFile('file')) {
            $attachment = Utility::saveFile('sanctions', $request->file('file'));
        }

        // $sanction = Sanction::create($validated);
        $sanction = Sanction::create([
            'ar' => $request->input('ar'),
            'ar_summary' => $request->input('ar_summary'),
            'sanction_summary' => $request->input('sanction_summary'),
            'evidence' => $attachment ? $attachment['path'] : null,
            'created_by' => auth()->user()->email,
            'institution' => auth()->user()->institution_id,
        ]);
        //
        $logMessage = auth()->user()->email . ' created a new sanction ';
        logAction(auth()->user()->email, 'New Sanction Created', $logMessage, $request->ip());
        //
        $ar = User::where('id', $request->ar)->first();
        $ar_name = $ar->first_name . ' ' . $ar->last_name;
        $ar_summary = $request->ar_summary;
        $sanction_summary = $request->sanction_summary;

        $megs = User::where(function ($query) {
            $query->where('role_id', Role::ARINPUTTER)->orWhere('role_id', Role::ARAUTHORISER);
        })->where('approval_status', 'approved')->get();
        //
        Notification::send($megs, new InfoNotification(MailContents::newSanctionMessage($ar_name, $ar_summary, $sanction_summary), MailContents::newSanctionMessageSubject()));
        //
        return successResponse('Sanction successfully created', $sanction);
    }
}
