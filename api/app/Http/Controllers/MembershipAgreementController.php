<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Application;
use App\Models\MemberAgreement;
use App\Models\User;

class MembershipAgreementController extends Controller
{

    public function preview($uuid)
    {

        $uuid = request('uuid');
        $application = Application::where('uuid', $uuid)->first();

        $membershipCategory = $application->membershipCategory;

        $data = Application::where('applications.id', $application->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        // $errorMsg = "Unable to complete your request at this point.";

        // if ($application->office_to_perform_next_action != Application::office['MEG']) {
        //     return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        // }

        // if ($application->currentStatus() != Application::statuses['M2AMR']) {
        //     return errorResponse(Response::HTTP_UNPROCESSABLE_ENTITY, $errorMsg);
        // }

        $applicant = User::find($application->submitted_by);

        if (!$details = MemberAgreement::where('application_id', $application->id)->first()) {
            return "error";
        }

        return view('agreement.' . $membershipCategory->code, ['details' => $details]);

    }

}
