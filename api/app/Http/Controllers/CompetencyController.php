<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Resources\CompetencyFrameworkResource;
use App\Http\Resources\CompetencyFrameworkARResource;
use App\Http\Resources\ComptencyResource;
use App\Models\Competency;
use App\Models\CompetencyFramework;
use App\Models\Position;
use App\Models\Role;
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
        return successResponse('Successful', CompetencyFrameworkResource::collection($competencies));
    }

    //
    public function listActive()
    {
        $competencies = CompetencyFramework::where('is_del', 0)->orderBy('created_at', 'DESC')->get()->toArray();
        // $competencies = CompetencyFramework::where('is_del', 0)->where('position', auth()->user()->position->position_group_id)->where('member_category', auth()->user()->category_id)->orderBy('created_at', 'DESC')->get()->toArray();
        return successResponse('Successful', $competencies);
    }

    public function listGroupName()
    {

        // $competencies = CompetencyFramework::where('is_del', 0)->where('position', auth()->user()->position->position_group_id)->where('member_category', auth()->user()->category_id)->orderBy('created_at', 'DESC')->get()->toArray();
        $competencies = CompetencyFramework::select('name', DB::raw('count(*) as total'))->groupBy('name')->orderBy('name', 'DESC')->get()->toArray();
        return successResponse('Successful', $competencies);
    }
    //

    public function listAllCompliantArs(): JsonResponse
    {

        // $competency = Competency::select('competency_frameworks.name', 'competency_frameworks.created_at', 'competency_frameworks.description', 'users.first_name', 'users.first_name', 'users.last_name', 'users.email', DB::raw('institutions.name as institution_name'))
        //     ->where('status', 'approved')
        //     ->leftJoin('competency_frameworks', 'competency_frameworks.id', '=', 'competencies.framework_id')
        //     ->join('users', 'users.id', '=', 'competencies.ar_id')
        //     ->join('institutions', 'institutions.id', '=', 'users.institution_id')->with(['framework'])
        //     ->get();

        $competencies = Competency::where('status', 'approved')->orderBy('created_at', 'DESC')->get();

        return successResponse('successful', ComptencyResource::collection($competencies));
    }

    //
    public function listAllNonCompliantArs(): JsonResponse
    {
        $competency = CompetencyFramework::select(DB::raw('users.id as user_ids'), DB::raw('competency_frameworks.id as competency_framework_id'), DB::raw('competency_frameworks.position as position'), DB::raw('competency_frameworks.member_category as member_category'), DB::raw('institutions.name as institution_name'), 'competency_frameworks.name', 'competency_frameworks.created_at', 'competency_frameworks.description', 'users.first_name', 'users.last_name', 'users.email')
            ->join('users', 'users.position_id', '=', 'competency_frameworks.position')
            ->join('institutions', 'institutions.id', '=', 'users.institution_id')
            ->leftJoin('competencies', function ($join) {
                $join->on('competencies.framework_id', '=', 'competency_frameworks.id');
                $join->on('competencies.ar_id', '=', 'users.id');
            })
            ->where('competencies.is_competent', null)
            ->where('institutions.name', '!=', null)
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

        $ars = User::whereIn('id', $ar_ids)->with(['institution', 'position', 'competency_response'])->get()->toArray();
        // $ars = User::where('position_id', $competency->position)->whereIn('id', $ar_ids)->with(['institution', 'position', 'competency_response'])->get()->toArray();

        return successResponse('successful', CompetencyFrameworkARResource::collection($ars));
    }

    //
    public function listNonCompliantArs($id): JsonResponse
    {

        $competency = CompetencyFramework::find($id);
        if (!$competency) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $ar_ids = Competency::where('framework_id', $id)->where('status', 'approved')->pluck('ar_id');

        $position_ids = Position::whereIn('position_group_id', $competency->position)->pluck('id');

        $ars = User::whereIn('position_id', $position_ids)->whereNotIn('id', $ar_ids)->with(['institution', 'position', 'competency_response'])->get()->toArray();

        return successResponse('successful', CompetencyFrameworkARResource::collection($ars));
    }

    //
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string",
            "description" => "required",
            "position" => "required|exists:position_groups,id",
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

        $status = request('action') == 'activate' ? 'Approved' : 'Declined';
        $competencyFramework = $competencies->framework;

        if (request('action') == 'activate') {
            $competencies->update([
                'status' => $request->status,
                'cco_id' => auth()->user()->id,
            ]);
        } else {

            $request->validate([
                'reason' => 'required',
            ]);

            $competencies->delete();

        }

        $ar = User::where('id', $competencies->ar_id)->first();
        $authoriser = auth()->user();

        Notification::send($ar, new InfoNotification(MailContents::arStatusCompetencyMessage($authoriser, $competencyFramework, $status), MailContents::arStatusCompetencySubject(), [$authoriser->email]));

        if (request('action') == 'activate') {
            $megs = Utility::getUsersEmailByCategory(Role::MEG);
            Notification::send($megs, new InfoNotification(MailContents::megArStatusCompetencyMessage($authoriser, $competencyFramework), MailContents::megArStatusCompetencySubject()));
        }

        return successResponse('Competency status updated', $competencies);
    }

    public function megStatusCompetency(Request $request): JsonResponse
    {

        $request->validate([
            'message' => 'required',
            'competency_id' => 'required',
        ]);

        if (!$competencies = Competency::find(request('competency_id'))) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $ars = User::whereIn('id', [$competencies->ar_id, $competencies->cco_id])->get();
        $megs = Utility::getUsersEmailByCategory(Role::MEG);
        $competencyFramework = $competencies->framework;
        $ar = $competencies->ar;
        $cco = $competencies->cco;
        $message = request('message');

        Notification::send($ars, new InfoNotification(MailContents::megStatusCompetencyMessage($message, $competencyFramework, $ar), MailContents::megStatusCompetencySubject()));

        $competencies->delete();

        $meg = auth()->user();

        $logMessage = "Competency rejected with deficiency: $message";
        logAction($meg->email, 'Competency Update', $logMessage, $request->ip());
        logAction($ar->email, 'Competency Update', $logMessage, $request->ip());
        logAction($cco->email, 'Competency Update', $logMessage, $request->ip());

        return successResponse('Competency status updated', $competencies);
    }

    public function megCopyCompetency(Request $request): JsonResponse
    {

        $request->validate([
            "evidence" => "required|mimes:jpeg,png,jpg,pdf",
            'competency_id' => 'required',
        ]);

        if (!$competency = Competency::find(request('competency_id'))) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        $competency->physical_copy = $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('evidence', 'public') : null;
        $competency->save();

        return successResponse('Competency file updated', $competency);
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
            'comment' => request('comment'),
            'is_competent' => $validated['is_competent'],
            'evidence' => $request->hasFile('evidence') ? $request->file('evidence')->storePublicly('evidence', 'public') : null,
            'status' => 'pending',
        ]);
        // mail
        $cco_position = Position::where('name', Position::CCO)->first();
        $ccos = User::where('position_id', $cco_position->id)->where('role_id', Role::ARAUTHORISER)->where('institution_id', auth()->user()->institution_id)->where('approval_status', 'approved')->get();
        //
        Notification::send($ccos, new InfoNotification(MailContents::submitCompetencyMessage($user), MailContents::submitCompetencySubject(), [$user->email]));
        // log
        $logMessage = $user->email . ' submitted a competency.';
        logAction($user->email, 'Submitted a competency', $logMessage, $request->ip());
        return successResponse('Competency submitted', $competency);
    }

}
