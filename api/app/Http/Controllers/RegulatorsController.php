<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\Regulator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegulatorsController extends Controller
{
    //
    public function index()
    {
        $regulators = Regulator::orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $regulators);
    }

    public function list()
    {
        $regulators = Regulator::where('is_del', 0)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $regulators);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string",
            "brief" => "required|string|max:50",
            "url" => "required|string|unique:regulators",
        ]);

        $user = auth()->user();
        $regulator = Regulator::create($validated);

        $logMessage = $user->email . ' created a regulator message named : ' . $request->name;
        logAction($user->email, 'New Regulator Created', $logMessage, $request->ip());
        //
        return successResponse('New Regulator Created', $regulator);

        //
    }
    //
    public function update(Request $request, $id): JsonResponse
    {
        $user = auth()->user();
        //
        $regulators = Regulator::find($id);
        if (!$regulators) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $validated = $request->validate([
            "name" => "required|string",
            "url" => "required|string",
            "brief" => "required|string|max:50",
        ]);
        //
        $regulators->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'brief' => $validated['brief'],
        ]);

        return successResponse('Update successful', $regulators);
    }

    //
    public function listActive()
    {
        $regulators = Regulator::where('status', 1)->orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $regulators);
    }
    //
    public function updateStatus(Request $request, $id)
    {
        $user = auth()->user();
        //
        $regulators = Regulator::find($id);
        if (!$regulators) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        //
        $regulators->update([
            'is_del' => $request->status,
        ]);

        return successResponse('Update successful', $regulators);
    }
}
