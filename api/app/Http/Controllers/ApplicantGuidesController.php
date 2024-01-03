<?php

namespace App\Http\Controllers;

use App\Models\ApplicantGuide;
use Illuminate\Http\Request;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;

class ApplicantGuidesController extends Controller
{
    //
    public function listAll()
    {
        $guides = ApplicantGuide::where('is_del', 0)->orderBy('created_at', 'DESC')->first();

        return successResponse('Successful', $guides);
    }

    //
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "required",
            "file" => "required"
        ]);
        //
        $attachment = [];

        if ($request->hasFile('file')) {
            $attachment = Utility::saveFile('guides', $request->file('file'));
        }
        //
        $applicant = ApplicantGuide::create([
            'name' => $request->input('name'),
            // 'file' => $request->hasFile('file') ? $request->file('file')->storePublicly('guides', 'public') : null,
            'file' => $attachment ? $attachment['path'] : null,
            'created_by' => auth()->user()->email
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' added an Applicant Guide';
        logAction($user->email, 'New Applicant Guide', $logMessage, $request->ip());
        //
        return successResponse('New Applicant Guide created', $applicant);
    }

    //
    public function update(Request $request, $id)
    {
        $guides = ApplicantGuide::find($id);
        if (!$guides) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $request->validate([
            "name" => "required",
            "file" => "mimes:pdf",
        ]);
        //
        $guides->update([
            'name' => $request->input('name'),
            'file' => $request->hasFile('file') ? $request->file('file')->storePublicly('applicant-guides', 'public') : null
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' updated the Applicant Guide';
        logAction($user->email, 'Update the Applicant Guide', $logMessage, $request->ip());
        //
        return successResponse('Update Successful', $guides);
    }

    //
    public function updateStatus(Request $request, $id)
    {
        //
        $guides = ApplicantGuide::find($id);
        // Check if the record exists
        if (!$guides) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        ApplicantGuide::where('is_del', 0)->update(['is_del' => 1]);
        //
        $guides->update(['is_del', 1]);
        // $guides->status = 1;
        // $update = $guides->update();
        //
        $user = auth()->user();
        $logMessage = $user->email . ' updated the status of the Applicant Guide';
        logAction($user->email, 'Updated Status the the Applicant Guide', $logMessage, $request->ip());
        return successResponse('Status Updated Successfully', $guides);
    }
    //
    public function listCurrent()
    {
        $guides = ApplicantGuide::where('is_del', 0)->orderBy('created_at', 'DESC')->first();

        return successResponse('Successful', $guides);
    }
}
