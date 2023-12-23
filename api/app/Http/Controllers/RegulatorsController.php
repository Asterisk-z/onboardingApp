<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\Regulator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RegulatorsController extends Controller
{
    //
    public function index()
    {
        $regulators = Regulator::orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $regulators);
    }

    //
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => "required|string",
            "url" => "required|string|unique:regulators",
        ]);

        $user = auth()->user();
        $regulator = Regulator::create($validated);
        // Regulator::create([
        //     'name' => $request->input('name'),
        //     'url' => $request->input('url'),
        // ]);

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
        ]);
        //
        $regulators->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
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
            'status' => $request->status
        ]);


        return successResponse('Update successful', $regulators);
    }
}
