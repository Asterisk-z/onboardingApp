<?php

namespace App\Http\Controllers;

use App\Models\CompetencyFramework;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ResponseStatusCodes;
use App\Models\Competency;
use App\Models\Position;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Support\Facades\Notification;
use App\Helpers\MailContents;
use App\Helpers\Utility;

class CompetencyController extends Controller
{
    //
    public function listAll()
    {
        $competencies = CompetencyFramework::where('is_del', 0)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $competencies);
    }

    //
    public function listActive()
    {
        $competencies = CompetencyFramework::where('is_del', 0)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $competencies);
    }

    //
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string",
            "description" => "required",
            "position" => "required|exists:positions,id",
            "member_category" => "required|exists:membership_categories,id"
        ]);

        $user = auth()->user();
        $competency =   CompetencyFramework::create([
            'name' =>  $validated['name'],
            'description' => $validated['description'],
            'member_category' => $validated['member_category'],
            'position' => $validated['position'],
            'created_by' => $user->email
        ]);

        $logMessage = $user->email . ' created a new competency framework named : ' . $validated['name'];
        logAction($user->email, 'New Competency Framework Created', $logMessage, $request->ip());
        return successResponse('New Competency Framework Created', $competency);
    }

    //
    public function update(Request $request, $id): JsonResponse
    {
        $user = auth()->user();
        //
        $competencies = CompetencyFramework::find($id);
        if (!$competencies) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $validated = $request->validate([
            "name" => "required|string",
            "description" => "required",
            "position" => "required|exists:positions,id",
            "member_category" => "required|exists:membership_categories,id"
        ]);
        //
        $competencies->update([
            'name' =>  $validated['name'],
            'description' => $validated['description'],
            'member_category' => $validated['member_category'],
            'position' => $validated['position'],
        ]);

        return successResponse('Update successful', $competencies);
    }

    //
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $competencies = CompetencyFramework::find($id);
        if (!$competencies) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $competencies->update([
            'is_del' => $request->status,
        ]);

        return successResponse('Status updated', $competencies);
    }

    //
    public function listARCompetencies(): JsonResponse
    {
        //
        $competencies = Competency::orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $competencies);
    }

    //
    public function statusCompetency(Request $request, $id): JsonResponse
    {
        //
        $competencies = Competency::find($id);
        if (!$competencies) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $competencies->update([
            'status' => $request->status,
        ]);

        return successResponse('Competency status updated', $competencies);
    }

    //
    public function submitCompetency(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "framework_id" => "required",
            "ar_id" => "required",
            "institution_id" => "required",
            "is_competent" => "required|boolean",
            "evidence" => "nullable|mimes:jpeg,png,jpg,pdf",
        ]);

        $user = auth()->user();
        $competency =   Competency::create([
            'framework_id' =>  $validated['framework_id'],
            'ar_id' => auth()->user()->id,
            'institution_id' => auth()->user()->institution_id,
            'is_competent' => $validated['is_competent'],
            'evidence' => $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('evidence', 'public') : null,
            'status' => 'pending'
        ]);
        // mail
        $cco_position = Position::where('name', Position::CCO)->first();
        $ccos = User::where('position_id', $cco_position->id)->where('approval_status', 'approved')->get();
        //
        Notification::send($ccos, new InfoNotification(MailContents::submitCompetencyMessage(), MailContents::submitCompetencySubject()));
        // log
        $logMessage = $user->email . ' submitted a competency.';
        logAction($user->email, 'Submitted a competency', $logMessage, $request->ip());
        return successResponse('Competency submitted', $competency);
    }
}
