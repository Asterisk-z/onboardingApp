<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\MembershipCategoryPostition;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::where('is_del', 0)->get(['id', 'name', 'is_del', 'can_be_authorizer'])->toArray();
        $converted_positions = Utility::arrayKeysToCamelCase($positions);

        $data = [
            'positions' => (array) $converted_positions,
        ];
        return successResponse('Positions Fetched Successfully', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(): JsonResponse
    {
        $positions = Position::orderBy('created_at', 'DESC')->with('categories')->get(['id', 'name', 'is_del', 'can_be_authorizer']);
        $converted_positions = Utility::arrayKeysToCamelCase($positions);
        $data = [
            'positions' => (array) $converted_positions,
        ];

        return successResponse('Position Fetched Successfully', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPosition(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:positions,name',
        ]);

        $positions = Position::create($validated);

        return successResponse('Position Created Successfully', $positions);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatusPosition(Request $request, Position $position): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|in:activate,deactivate',
        ]);

        if ($request->action == 'activate') {

            $position->is_del = Position::ACTIVATE;
            $position->save();

        } else {

            $position->is_del = Position::DEACTIVATE;
            $position->save();

        }

        return successResponse('Position  Successfully', $position);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(Request $request, Position $position): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:positions,name',
        ]);

        $position->name = $request->name;
        $position->is_del = Position::ACTIVATE;
        $position->save();

        return successResponse('Position Successfully', $position);

    }

    public function mapToCategories(Request $request)
    {

        $request->validate([
            "position" => "required|exists:positions,id",
            "category" => "required|array",
            "category.*" => "required|exists:membership_categories,id",
        ]);

        $categories = request('category');

        foreach ($categories as $category) {
            if (MembershipCategoryPostition::where('category_id', $category)->where('position_id', request('position'))->exists()) {
                continue;
            }
            MembershipCategoryPostition::create([
                'position_id' => request('position'),
                'category_id' => $category,
            ]);
        }
        return successResponse('Positions Linked to Category successfully');

    }

    public function unlinkFromCategories(Request $request)
    {

        $request->validate([
            "position" => "required|exists:positions,id",
            "category" => "required|array",
            "category.*" => "required|exists:membership_categories,id",
        ]);

        $categories = request('category');

        foreach ($categories as $category) {
            if (MembershipCategoryPostition::where('category_id', $category)->where('position_id', request('position'))->exists()) {

                $pivot = MembershipCategoryPostition::where('category_id', $category)->where('position_id', request('position'))->delete();

            }
        }
        return successResponse('Positions UnLinked from Category successfully');

    }
}
