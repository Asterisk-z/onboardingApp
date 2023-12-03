<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $complaints = $user->complaints;
        return successResponse('Your complaint has been submitted.', $complaints);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            "complaint_type" => "required|exists:complaint_types,id",
            "body" => "required|string",
            "document" => "nullable|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048"
        ]);

        $user = $request->user();

        $user->complaints()->create([
            'document' => $request->hasFile('document') ? $request->file('document')->storePublicly('complaint','public') : null,
            'body' => $request->input('body'),
            'complaint_type_id' => $request->input('complaint_type')
        ]);

        //TODO::Notify MEG

        return successResponse('Your complaint has been submitted.');
    }

        /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function feedback(Request $request)
    {
        $request->validate([
            "complaint_id" => "required|exists:complaints,id",
            "comment" => "required|string",
            "status" => "nullable|in:ONGOING,CLOSED"
        ]);

        $user = $request->user();

        $comment = $user->comments()->create([
            'complaint_id' => $request->input('complaint_id'),
            'comment' => $request->input('comment')
        ]);

        $comment->complaint()->update([
            "status" => $request->input('status') ?? "ONGOING"
        ]);

        //TODO::Notify complainer

        return successResponse('Your comment has been submitted.');
    }

        /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            "complaint_id" => "required|exists:complaints,id",
            "status" => "required|in:ONGOING,CLOSED"
        ]);

        Complaint::find($request->input('complaint_id'))->update([
            "status" => $request->input('status')
        ]);

        return successResponse('Status changed successfully.');
    }
}
