<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\Settings\AddCategoryRequest;
use App\Models\MembershipCategory;
use App\Models\MembershipCategoryPostition;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $categories = MembershipCategory::where('is_del', 0)->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $data);

    }

    public function positions(CategoryRequest $request): JsonResponse
    {
        $position_ids = MembershipCategoryPostition::whereIn('category_id', $request->category_ids)->pluck('position_id');
        $positions = Position::whereIn('id', $position_ids)->get();

        return successResponse('Here you go', $positions);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(): JsonResponse
    {
        $categories = MembershipCategory::orderBy('created_at', 'DESC')->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCategory(AddCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $categories = MembershipCategory::create($validated);

        return successResponse('Membership Created Successfully', $categories);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatusCategory(Request $request, MembershipCategory $category): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|in:activate,deactivate',
        ]);

        if ($request->action == 'activate') {

            $category->is_del = MembershipCategory::ACTIVATE;
            $category->save();

        } else {

            $category->is_del = MembershipCategory::DEACTIVATE;
            $category->save();

        }

        return successResponse('Membership  Successfully', $category);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request, MembershipCategory $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|exists:membership_categories,code',
        ]);

        $category->name = $request->name;
        $category->code = $request->code;
        $category->is_del = MembershipCategory::ACTIVATE;
        $category->save();

        return successResponse('Membership Successfully', $category);

    }
}
