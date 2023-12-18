<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\ComplaintType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComplaintTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compliant_types = ComplaintType::where('is_del', '0')->orderBy('name', 'DESC')->get();
        $converted_compliant_types = Utility::arrayKeysToCamelCase($compliant_types);

        $data = [
            'compliant_types' => (array) $converted_compliant_types,
        ];
        return successResponse('Complaint Types Fetched Successfully', $data);
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
            "name" => "required|string"
        ]);
        //
        ComplaintType::create([
            'name' => $request->input('name'),
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' created a complaint type : ' . $request->name;
        logAction($user->email, 'Complaint type created', $logMessage, $request->ip());
        //
        return successResponse('Complaint type for ' . $request->name . ' was successfully created');
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
    public function update(Request $request)
    {
        //
        $request->validate([
            "id" => "required",
            "name" => "required|string"
        ]);
        //
        // Find the complaint type by ID
        $complaintType = ComplaintType::find($request->input('id'));
        if (!$complaintType) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Complaint type not found');
        }
        //

        // $user = auth()->user();
        // $logMessage = $user->email . ' created a complaint type : ' . $request->name;
        // logAction($user->email, 'Complaint type created', $logMessage, $request->ip());
        // //
        // return successResponse('Complaint type for ' . $request->name . ' was successfully created');
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
