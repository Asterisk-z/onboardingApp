<?php

namespace App\Http\Controllers;

use App\Models\MemberGuide;
use Illuminate\Http\Request;
use App\Helpers\ResponseStatusCodes;

class MemberGuidesController extends Controller
{
    //
    public function listAll()
    {
        $guides = MemberGuide::where('is_del', 0)->orderBy('created_at', 'DESC')->get();

        return successResponse('Successful', $guides);
    }

    //
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "required",
            "file" => "required|mimes:pdf",
        ]);
        //
        $member = MemberGuide::create([
            'name' => $request->input('name'),
            'file' => $request->hasFile('file') ? $request->file('file')->storePublicly('applicant-guides', 'public') : null,
            'created_by' => auth()->user()->email
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' added a Member Guide';
        logAction($user->email, 'New Member Guide', $logMessage, $request->ip());
        //
        return successResponse('New Member Guide created', $member);
    }

    //
    public function update(Request $request, $id)
    {
        $guides = MemberGuide::find($id);
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
        $logMessage = $user->email . ' updated the Member Guide';
        logAction($user->email, 'Update the Member Guide', $logMessage, $request->ip());
        //
        return successResponse('Update Successful', $guides);
    }

    //
    public function updateStatus(Request $request, $id)
    {
        //
        $guides = MemberGuide::find($id);
        // Check if the record exists
        if (!$guides) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        MemberGuide::where('is_del', 0)->update(['is_del' => 1]);
        //
        $guides->update(['is_del', 1]);
        // $guides->status = 1;
        // $update = $guides->update();
        //
        $user = auth()->user();
        $logMessage = $user->email . ' updated the status of the Member Guide';
        logAction($user->email, 'Updated Status the the Member Guide', $logMessage, $request->ip());
        return successResponse('Status Updated Successfully', $guides);
    }
    //
    public function listCurrent()
    {
        $guides = MemberGuide::where('is_del', 0)->orderBy('created_at', 'DESC')->first();

        return successResponse('Successful', $guides);
    }
}
