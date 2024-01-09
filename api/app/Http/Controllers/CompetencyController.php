<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Models\Competency;
use App\Models\CompetencyFramework;
use App\Models\Position;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CompetencyController extends Controller
{
    //
    public function listAll()
    {
        $competencies = CompetencyFramework::orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $competencies);
    }

    //
    public function listActive()
    {
        $competencies = CompetencyFramework::where('is_del', 0)->where('position', auth()->user()->position_id)->orderBy('created_at', 'DESC')->get()->toArray();
        return successResponse('Successful', $competencies);
    }

    //

    public function listAllCompliantArs(): JsonResponse
    {

        $competency = Competency::select('competency_frameworks.name', 'competency_frameworks.created_at', 'competency_frameworks.description', 'users.first_name', 'users.first_name', 'users.last_name', 'users.email', DB::raw('institutions.name as institution_name'))
            ->where('status', 'approved')
            ->leftJoin('competency_frameworks', 'competency_frameworks.id', '=', 'competencies.framework_id')
            ->join('users', 'users.id', '=', 'competencies.ar_id')
            ->join('institutions', 'institutions.id', '=', 'users.institution_id')->with(['framework'])
            ->get();

        return successResponse('successful', $competency);
    }

    //
    public function listAllNonCompliantArs(): JsonResponse
    {
        $competency = CompetencyFramework::select(DB::raw('users.id as user_ids'), DB::raw('competency_frameworks.id as competency_framework_id'), DB::raw('institutions.name as institution_name'), 'competency_frameworks.name', 'competency_frameworks.created_at', 'competency_frameworks.description', 'users.first_name', 'users.last_name', 'users.email')
            ->join('users', 'users.position_id', '=', 'competency_frameworks.position')
            ->join('institutions', 'institutions.id', '=', 'users.institution_id')
            ->leftJoin('competencies', function ($join) {
                $join->on('competencies.framework_id', '=', 'competency_frameworks.id');
                $join->on('competencies.ar_id', '=', 'users.id');
            })
            ->where('competencies.is_competent', null)
            ->get();

        return successResponse('successful', $competency);
    }

    public function listCompliantArs($id): JsonResponse
    {

        $competency = CompetencyFramework::find($id);
        if (!$competency) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $ar_ids = Competency::where('framework_id', $id)->where('status', 'approved')->pluck('ar_id');

        $ars = User::where('position_id', $competency->position)->whereIn('id', $ar_ids)->with(['institution', 'position', 'competency_response'])->get()->toArray();

        return successResponse('successful', $ars);
    }

    //
    public function listNonCompliantArs($id): JsonResponse
    {

        $competency = CompetencyFramework::find($id);
        if (!$competency) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $ar_ids = Competency::where('framework_id', $id)->where('status', 'approved')->pluck('ar_id');

        $ars = User::where('position_id', $competency->position)->whereNotIn('id', $ar_ids)->with(['institution', 'position', 'competency_response'])->get()->toArray();

        return successResponse('successful', $ars);
    }

    //
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string",
            "description" => "required",
            "position" => "required|exists:positions,id",
            "member_category" => "required|exists:membership_categories,id",
        ]);

        $user = auth()->user();
        $competency = CompetencyFramework::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'member_category' => $validated['member_category'],
            'position' => $validated['position'],
            'created_by' => $user->email,
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
            "member_category" => "required|exists:membership_categories,id",
        ]);
        //
        $competencies->update([
            'name' => $validated['name'],
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

        $request->validate([
            'action' => 'required',
        ]);

        if (request('action') == 'activate') {
            $competencies->update([
                'is_del' => 0,
                'reason' => null,
            ]);
        } else {

            $request->validate([
                'reason' => 'required',
            ]);

            $competencies->update([
                'is_del' => 1,
                'reason' => request('reason'),
            ]);

        }

        return successResponse('Status updated', $competencies);
    }

    //
    public function listARCompetencies(): JsonResponse
    {
        //
        $competencies = Competency::where('institution_id', auth()->user()->institution_id)->with('framework')->orderBy('status', 'DESC')->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $competencies);
    }

    //
    public function statusCompetency(Request $request): JsonResponse
    {

        $request->validate([
            'action' => 'required',
            'status' => 'required',
            'competency_id' => 'required',
        ]);

        $competencies = Competency::find(request('competency_id'));
        if (!$competencies) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        if (request('action') == 'activate') {
            $competencies->update([
                'status' => $request->status,
                'cco_id' => auth()->user()->id,
            ]);
        } else {

            $request->validate([
                'reason' => 'required',
            ]);

            $ar = User::where('id', $competencies->id)->first();

            Notification::send($ar, new InfoNotification(MailContents::rejectedCompetencyMessage(request('reason')), MailContents::rejectedCompetencySubject()));

            $competencies->delete();

        }

        return successResponse('Competency status updated', $competencies);
    }

    //
    public function submitCompetency(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "framework_id" => "required",
            "is_competent" => "required|boolean",
            "evidence" => "nullable|mimes:jpeg,png,jpg,pdf",
        ]);

        $user = auth()->user();
        $competency_response = Competency::where('framework_id', $request->framework_id)->where('ar_id', auth()->user()->id)->first();
        if ($competency_response) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'You have responded to this competency');
        }

        $competency = Competency::create([
            'framework_id' => $validated['framework_id'],
            'ar_id' => auth()->user()->id,
            'institution_id' => auth()->user()->institution_id,
            'is_competent' => $validated['is_competent'],
            'evidence' => $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('evidence', 'public') : null,
            'status' => 'pending',
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
