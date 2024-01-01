<?php

namespace App\Http\Controllers;

use App\Models\CompetencyFramework;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\ResponseStatusCodes;

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
}
