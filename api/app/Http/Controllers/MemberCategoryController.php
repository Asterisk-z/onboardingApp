<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\Settings\AddCategoryRequest;
use App\Models\MembershipCategory;
use Illuminate\Http\JsonResponse;

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

    public function positions(MembershipCategory $category): JsonResponse
    {
        return successResponse('Here you go', $category->positions);
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
