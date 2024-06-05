<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Resources\SanctionResource;
use App\Models\Role;
use App\Models\Sanction;
use App\Models\SanctionType;
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

        return successResponse('Successful', SanctionResource::collection($sanctions));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTypes()
    {
        $sanction_type = SanctionType::where('is_del', '0')->orderBy('name', 'DESC')->get();
        $converted_sanction_type = Utility::arrayKeysToCamelCase($sanction_type);

        $data = [
            'sanction_type' => (array) $converted_sanction_type,
        ];
        return successResponse('Sanction Types Fetched Successfully', $data);
    }
    //
    public function mySanction()
    {
        $sanctions = Sanction::where('institution', auth()->user()->institution_id)->orderBy('created_at', 'DESC')->get();

        return successResponse('Successful', SanctionResource::collection($sanctions));

    }

    //
    public function store(Request $request): JsonResponse
    {
        //
        $request->validate([
            "ar" => ["required", "string", new ValidArRole],
            "ar_summary" => "required|string",
            "type_id" => "required",
            "sanction_summary" => "required|string",
            "evidence" => "required|mimes:pdf",
        ]);

        $attachment = $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('sanctions', 'public') : null;

        // $sanction = Sanction::create($validated);
        $sanction = Sanction::create([
            'ar' => $request->input('ar'),
            'ar_summary' => $request->input('ar_summary'),
            'type_id' => $request->input('type_id'),
            'sanction_summary' => $request->input('sanction_summary'),
            'evidence' => $attachment,
            'created_by' => auth()->user()->email,
            'institution' => auth()->user()->institution_id,
            "status" => 'pending',
        ]);
        //
        $logMessage = auth()->user()->email . ' created a new sanction ';
        logAction(auth()->user()->email, 'New Sanction Created', $logMessage, $request->ip());
        //
        $ar = User::where('id', $request->ar)->first();
        $ar_name = $ar->first_name . ' ' . $ar->last_name;
        $ar_reg = $ar->reg_id;
        $ar_summary = $request->ar_summary;
        $sanction_summary = $request->sanction_summary;

        $ars = User::where(function ($query) {
            $query->where('role_id', Role::ARINPUTTER)
                ->orWhere('role_id', Role::ARAUTHORISER);
        })->where('approval_status', 'approved')->get();

        $megs = User::where(function ($query) {
            $query->where('role_id', Role::MEG);
        })->where('approval_status', 'approved')->get();
        //
        // Notification::send($ars, new InfoNotification(MailContents::newSanctionMessage($ar_name, $ar_summary, $sanction_summary), MailContents::newSanctionMessageSubject()));
        Notification::send($megs, new InfoNotification(MailContents::newMegSanctionMessage($ar_reg, $ar_name), MailContents::newMegSanctionMessageSubject()));
        //
        return successResponse('Sanction successfully created', $sanction);
    }
    //

    public function updateStatus(Request $request): JsonResponse
    {
        //
        $request->validate([
            "sanction_id" => "required|integer",
            "status" => "required|string|in:closed,investigating",
        ]);

        if (!$sanction = Sanction::where('id', request('sanction_id'))->whereIn('status', ['investigating', 'pending'])->first()) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Can not perform this action at this point');
        }

        // $sanction = Sanction::create($validated);
        $sanction->status = request('status');
        $sanction->save();
        //
        $ar = User::where('id', $sanction->ar)->first();
        $logMessage = auth()->user()->email . ' updated a sanction ';
        logAction(auth()->user()->email, 'Sanction Update', $logMessage, $request->ip());
        logAction($ar->email, 'Sanction Update', $logMessage, $request->ip());

        return successResponse('Sanction successfully updated', $sanction);
    }
}
