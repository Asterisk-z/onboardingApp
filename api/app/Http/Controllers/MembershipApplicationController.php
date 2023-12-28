<?php

namespace App\Http\Controllers;

use App\Models\ApplicationField;
use App\Models\ApplicationFieldOption;
use App\Models\ApplicationFieldUpload;
use Illuminate\Http\Request;

class MembershipApplicationController extends Controller
{
    //

    public function getField(Request $request)
    {
        $application_fields = ApplicationField::where('parent_id', null);

        if ($request->page) {
            $application_fields->where('page', $request->page);
        }

        if ($request->category) {
            $application_fields->where('category', $request->category);
        }

        $data = $application_fields->orderBy('id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', $data);
    }

    public function getFieldOption(Request $request)
    {
        $application_fields = ApplicationFieldOption::query();

        if ($request->category) {
            $application_fields->where('category', $request->category);
        }

        if ($request->field_name) {
            $application_fields->where('field_name', $request->field_name);
        }

        $data = $application_fields->orderBy('id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', $data);
    }

    public function uploadField(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'field_name' => 'required',
            'field_value' => 'required',
            'field_type' => 'required',
        ]);

        if (!ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->exists()) {
            return;
        }

        $applicationField = ApplicationField::where('category', $request->category_id)
            ->where('name', $request->field_name)
            ->where('type', $request->field_type)->first();

        $data = ['uploaded_field' => $request->field_value];

        if($request->field_type == 'file') {
            $data = ['uploaded_file' => $request->field_value];
        }

        ApplicationFieldUpload::updateOrCreate(
            ['application_field_id' => $applicationField->id, 'application_id' => auth()->user()->institution->application->id],
            $data
        );

        return successResponse('Fields Fetched Successfully', auth()->user()->institution->application);

    }
}
