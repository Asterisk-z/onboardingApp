<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Models\FeesAndDues;
use Illuminate\Http\Request;

class FeesAndDuesController extends Controller
{
    //
    public function index()
    {
        $fees = FeesAndDues::orderBy('created_at', 'DESC')->get();

        return successResponse('Successful', $fees);
    }

    //
    public function store(Request $request)
    {
        // dd($request->all());
        //
        $request->validate([
            "title" => "required|string",
            "url" => "required|string"
        ]);
        //
        FeesAndDues::create([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'status' => $request->input('status')
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' added a FMDQ Fees and Dues Framework : ' . $request->title;
        logAction($user->email, 'Fees and Dues Framework', $logMessage, $request->ip());
        //
        return successResponse('Successful');
    }

    //
    public function update(Request $request, $id)
    {
        $fees = FeesAndDues::find($id);
        if (!$fees) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $request->validate([
            "title" => "required|string",
            "url" => "required|string"
        ]);
        //
        $fees->update([
            'title' => $request->input('title'),
            'url' => $request->input('url')
        ]);
        //
        $user = auth()->user();
        $logMessage = $user->email . ' updated the FMDQ Fees and Dues Framework';
        logAction($user->email, 'Update the Fees and Dues Framework', $logMessage, $request->ip());
        //
        return successResponse('Update Successful');
    }

    //
    public function delete($id)
    {
        //
        $fees = FeesAndDues::find($id);
        // Check if the record exists
        if (!$fees) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }
        //
        $fees->delete();

        return successResponse('Delete successful');
    }
}
