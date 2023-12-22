<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\Role;
use App\Models\Sanction;
use App\Models\User;
use App\Rules\ValidArRole;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Notifications\InfoNotification;
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
    public function fetchAR()
    {
        $ars = User::where('is_active', 1)->where('is_del', 0)
            ->where(function ($query) {
                $query->where('role_id', 5)
                    ->orWhere('role_id', 6);
            })
            ->get();

        return successResponse('Successful', $ars);
    }

    //
    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();
        // dd($request->all());
        $request->validate([
            "ar" => ["required", "string", new ValidArRole],
            "ar_summary" => "required|string",
            "sanction_summary" => "required|string",
            "evidence" => "required|mimes:pdf",
            // "evidence" => "required",
            "created_by" => "required"
        ]);

        // $sanction = Sanction::create($validated);
        $sanction =  Sanction::create([
            'ar' => $request->input('ar'),
            'ar_summary' => $request->input('ar_summary'),
            'sanction_summary' => $request->input('sanction_summary'),
            'evidence' => $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('evidence', 'public') : null,
            'created_by' => $user->email
        ]);
        //
        $logMessage = $user->email . ' created a new sanction ';
        logAction($user->email, 'New Sanction Created', $logMessage, $request->ip());
        //
        $ar = User::where('id', $request->ar)->first();
        $ar_name = $ar->first_name . ' ' . $ar->last_name;
        $ar_summary = $request->ar_summary;
        $sanction_summary = $request->sanction_summary;

        $megs = User::where(function ($query) {
            $query->where('role_id', Role::ARINPUTTER)->orWhere('role_id', Role::ARAUTHORISER);
        })->where('approval_status', 'approved')->get();
        //7
        Notification::send($megs, new InfoNotification(MailContents::newSanctionMessage($ar_name, $ar_summary, $sanction_summary), MailContents::newSanctionMessageSubject()));
        //
        return successResponse('Sanction successfully created', $sanction);
    }
}
