<?php

namespace App\Http\Controllers;

use App\Models\ApplicationField;
use Illuminate\Http\Request;

class MembershipApplicationController extends Controller
{
    //

    public function getfield(Request $request)
    {
        $application_fields = ApplicationField::query();

        if($request->page) {
            $application_fields->where('page', $request->page);
        }

        if($request->category) {
            $application_fields->where('category', $request->category);
        }

        $data = $application_fields->orderBy('id', 'ASC')->get();

        return successResponse('Fields Fetched Successfully', $data);
    }
}
