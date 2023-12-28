<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\ApplicantGuide;
use Illuminate\Http\Request;

class ApplicantGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $applicants = ApplicantGuide::orderBy('created_at', 'DESC')->get();
        return successResponse('Successful', $applicants);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "required|string",
            "file" => "required|mimes:pdf",
            "status" => "required|string",
            "created_by" => "required"
        ]);
        $user = auth()->user();
        $attachment = [];

        if ($request->hasFile('file')) {
            $attachment = Utility::saveFile('applicant-guides', $request->file('file'));
        }

        // $sanction = Sanction::create($validated);
        $applicants =  ApplicantGuide::create([
            'name' => $request->input('name'),
            'file' => $attachment ? $attachment['path'] : null,
            'status' => true,
            'created_by' => $user->email
        ]);
        //
        $logMessage = $user->email . ' created an applicant guides ';
        logAction($user->email, 'New Applicant Guides Created', $logMessage, $request->ip());
        //
        return successResponse('Sanction successfully created', $applicants);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
