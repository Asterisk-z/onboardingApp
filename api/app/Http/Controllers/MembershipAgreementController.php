<?php

namespace App\Http\Controllers;

use App\Helpers\ESuccessLetter;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\MemberAgreement;
use App\Models\MemberESuccessLetter;
use Illuminate\Support\Facades\Storage;
use PDF;

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

        // $applicant = User::find($application->submitted_by);

        // if (!$details = MemberAgreement::where('application_id', $application->id)->first()) {
        //     return "error";
        // }

        $membershipCategory = $application->membershipCategory;

        if (!$details = MemberAgreement::where('application_id', $application->id)->first()) {
            return "error";
        }
        // // logger($membershipCategory->code);
        // $pdf = PDF::loadView('agreement.' . $membershipCategory->code, compact('details'));
        $pdf = PDF::loadView('agreement.aft', compact('details'));
        Storage::put('public/agreement/e_membership_agreement' . $application->id . '.pdf', $pdf->output());
        $application->membership_agreement = 'agreement/e_membership_agreement' . $application->id . '.pdf';
        $application->save();

        // return view('agreement.' . $membershipCategory->code, ['details' => $details]);
        return view('agreement.aft', ['details' => $details]);

    }

    public function previewLetter($uuid)
    {

        $uuid = request('uuid');
        $application = Application::where('uuid', $uuid)->first();

        $membershipCategory = $application->membershipCategory;

        $data = Application::where('applications.id', $application->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        if (!$detail = MemberESuccessLetter::where('application_id', $application->id)->first()) {
            return "error";
        }

        $content = (new ESuccessLetter())->generate($application, true);

        return view('success.e-letter', ['content' => $content]);

    }

}
