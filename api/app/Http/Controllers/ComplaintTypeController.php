<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\ComplaintType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComplaintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compliant_types = ComplaintType::where('is_del', '0')->orderBy('name', 'DESC')->get();
        $converted_compliant_types = Utility::arrayKeysToCamelCase($compliant_types);

        $data = [
            'compliant_types' => (array) $converted_compliant_types,
        ];
        return successResponse('Complaint Types Fetched Successfully', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(): JsonResponse
    {
        $compliant_types = ComplaintType::orderBy('created_at', 'DESC')->get(['id', 'name', 'is_del'])->toArray();
        $converted_compliant_types = Utility::arrayKeysToCamelCase($compliant_types);
        $data = [
            'compliant_types' => (array) $converted_compliant_types,
        ];

        return successResponse('Complaint Types Fetched Successfully', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addComplainType(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:complaint_types,name',
        ]);

        $compliant_types = ComplaintType::create($validated);

        return successResponse('Complaint Type Created Successfully', $compliant_types);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatusComplainType(Request $request, ComplaintType $complainType): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|in:activate,deactivate',
        ]);

        if ($request->action == 'activate') {

            $complainType->is_del = ComplaintType::ACTIVATE;
            $complainType->save();
        } else {

            $complainType->is_del = ComplaintType::DEACTIVATE;
            $complainType->save();
        }

        return successResponse('ComplainType  Successfully', $complainType);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateComplainType(Request $request, ComplaintType $complainType): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:complaint_types,name',
        ]);

        $complainType->name = $request->name;
        $complainType->is_del = ComplaintType::ACTIVATE;
        $complainType->save();

        return successResponse('ComplainType Successfullyd', $complainType);
    }
}
