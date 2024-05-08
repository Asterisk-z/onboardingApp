<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\Settings\AddCategoryRequest;
use App\Models\Application;
use App\Models\InstitutionMembership;
use App\Models\MembershipCategory;
use App\Models\MembershipCategoryPostition;
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
    public function myApplicationCategories(): JsonResponse
    {
        $membership_category_ids = Application::where('institution_id', auth()->user()->institution_id)
            ->where('is_applicant_executed_membership_agreement', true)
            ->whereIn('application_type_status', [Application::typeStatus['ASC'], Application::typeStatus['ASP']])
            ->pluck('membership_category_id');
        $categories = MembershipCategory::whereIn('id', $membership_category_ids)->where('is_del', 0)->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $data);
    }

    public function myCategories(): JsonResponse
    {
        $membership_category_ids = InstitutionMembership::where('institution_id', auth()->user()->institution_id)->pluck('membership_category_id');
        $categories = MembershipCategory::whereIn('id', $membership_category_ids)->where('is_del', 0)->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $data);

    }
    public function otherCategories(): JsonResponse
    {
        $membership_category_ids = InstitutionMembership::where('institution_id', auth()->user()->institution_id)->pluck('membership_category_id');
        $categories = MembershipCategory::whereNotIn('id', $membership_category_ids)->where('is_del', 0)->get(['id', 'name', 'code', 'is_del'])->toArray();
        $converted_categories = Utility::arrayKeysToCamelCase($categories);
        $data = [
            'categories' => (array) $converted_categories,
        ];
        return successResponse('Membership Fetched Successfully', $data);

    }

    public function positions(CategoryRequest $request): JsonResponse
    {
        // $position_ids = MembershipCategoryPostition::whereIn('category_id', $request->category_ids)->pluck('position_id');
        // $positions = Position::whereIn('positions.id', $position_ids)->get();
// ->leftJoin('membership_category_postitions', 'positions.id', '=', 'membership_category_postitions.position_id')

        $position_ids = MembershipCategoryPostition::whereIn('membership_category_postitions.category_id', $request->category_ids)
            ->rightJoin('positions', 'positions.id', '=', 'membership_category_postitions.position_id')
            ->select('positions.*', 'membership_category_postitions.is_compulsory')
            ->orderBy('membership_category_postitions.is_compulsory')->get();

        return successResponse('Here you go', $position_ids);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(): JsonResponse
    {
        $categories = MembershipCategory::orderBy('created_at', 'DESC')->with('positions')->get(['id', 'name', 'code', 'is_del']);
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

    public function mapToPositions(Request $request)
    {
        $request->validate([
            "category" => "required|exists:membership_categories,id",
            "position" => "required|array",
            "position.*" => "required|exists:positions,id",
        ]);

        $positions = request('position');

        foreach ($positions as $position) {
            if (MembershipCategoryPostition::where('position_id', $position)->where('category_id', request('category'))->exists()) {
                continue;
            }
            MembershipCategoryPostition::create([
                'category_id' => request('category'),
                'position_id' => $position,
            ]);
        }
        return successResponse('Category Linked to Position successfully');

    }

    public function unlinkFromPositions(Request $request)
    {

        $request->validate([
            "category" => "required|exists:membership_categories,id",
            "position" => "required|array",
            "position.*" => "required|exists:positions,id",
        ]);

        $positions = request('position');

        foreach ($positions as $position) {
            if (MembershipCategoryPostition::where('position_id', $position)->where('category_id', request('category'))->exists()) {

                $pivot = MembershipCategoryPostition::where('position_id', $position)->where('category_id', request('category'))->delete();

            }
        }
        return successResponse('Category UnLinked from Position successfully');

    }
}
