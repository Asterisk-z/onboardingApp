<?php

namespace App\Http\Controllers;

use App\Events\ApplicationSubmissionEvent;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\ApplicationExtra;
use App\Models\ApplicationField;
use App\Models\ApplicationFieldOption;
use App\Models\ApplicationFieldUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function getFieldExtra(Request $request)
    {
        $application_fields = ApplicationExtra::query();
        $data = [];

        if ($request->category && $request->name) {
            $application_fields->where('category_id', $request->category)->where('name', $request->name);
            $data = $application_fields->orderBy('id', 'ASC')->first();
        }

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

        if ($request->field_type == 'file') {

            if ($request->hasFile('field_value')) {
                $attachment = Utility::saveFile('application/' . auth()->user()->institution->application->id . '/' . $request->field_name, $request->file('field_value'));
            }
            $data['uploaded_field'] = null;
            $data = ['uploaded_file' => $attachment['path']];

        }

        ApplicationFieldUpload::updateOrCreate(
            ['application_field_id' => $applicationField->id, 'application_id' => auth()->user()->institution->application->id],
            $data
        );

        return successResponse('Fields Fetched Successfully', auth()->user()->institution->application);

    }

    /**
     * This method does the final submission of an application
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function complete(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id',
        ]);

        //Get authenticated user
        $user = auth()->user();

        //Get the application model
        $application = Application::find($request->application_id);

        if ($application->status == Application::AWAITINGAPPROVAL) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, "Your application has already been submitted and it is currently under review.");
        }

        //Get the insitution from the application
        $institution = $application->institution;

        $errorMsg = "Unable to complete your request at this point.";

        if (!$institution) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Checks that the institution returned is the same as that of the authenticated user
        if ($user->institution_id != $institution->id) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Get the first membership of an institution
        $membershipCategory = $institution->membershipCategories->first();

        if (!$membershipCategory) {
            return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        }

        //Get all the required fields per membership category
        $requiredFieldIds = $membershipCategory->fields->where('required', 1)->pluck('id')->toArray();

        //Check for any missing required field by comparing what is required and all that was uploaded
        $applicationFieldIds = $application->uploads->pluck('application_field_id')->toArray();

        $missingFieldIds = array_diff(
            $requiredFieldIds,
            $applicationFieldIds
        );

        if (!empty($missingFieldIds)) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Submission failed. There are required fields you are yet to fill.");
        }

        $application->status = Application::AWAITINGAPPROVAL;
        $application->save();

        event(new ApplicationSubmissionEvent($user, $application, $institution, $membershipCategory));

        return successResponse("Your Application has been submitted and is under review. You will be notified any feedback soon");
    }
}
