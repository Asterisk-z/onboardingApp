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
        $categories = MembershipCategory::orderBy('created_at')->get(['id', 'name', 'code', 'is_del'])->toArray();
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

        $categories = MembershipCategory::orderBy('created_at')->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $validated);

    }
}
