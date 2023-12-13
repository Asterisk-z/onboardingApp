<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\MembershipCategory;
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

    public function positions(MembershipCategory $category)
    {
        return successResponse('Here you go', $category->positions);
    }
}
