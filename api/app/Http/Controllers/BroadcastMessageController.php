<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Broadcast;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BroadcastMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $broadcasts = Broadcast::orderBy('created_at', 'DESC')->get();

        return successResponse('Successful', $broadcasts);
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
        $request->validate([
            "title" => "required|string",
            "content" => "required|string",
            "file" => "nullable|mimes:jpeg,png,jpg,pdf,doc,docx,csv,xls,xlsx|max:5048",
            "category" => "required|array",
            "category.*" => "required|exists:membership_categories,id",
            "position" => "required|array",
            "position.*" => "required|exists:positions,id"
        ]);

        $user = auth()->user();

        $attachment = [];

        if($request->hasFile('file')){
            $attachment = Utility::saveFile('broadcast', $request->file('file'));
        }

        Broadcast::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'file' => $attachment ? $attachment['path'] : null,
            'category' => json_encode($request->input('category')),
            'position' => json_encode($request->input('position')),
        ]);

        $ars = User::where(function ($query) {
                $query->where('role_id', Role::ARINPUTTER)->orWhere('role_id', Role::ARAUTHORISER);
            })->where('approval_status', 'approved')->whereIn('position_id', $request->position)->get();

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        //
        Notification::send($ars, new InfoNotification(MailContents::newBroadcastMessage($request->input('title'), $request->input('content')), MailContents::newBroadcastMessageSubject(), $MEGs, $attachment));

        $logMessage = $user->email . ' created a broadcast message named : ' . $request->title;
        logAction($user->email, 'Broadcast Message Created', $logMessage, $request->ip());
        //
        return successResponse('Broadcast message for ' . $request->title . ' was successfully created');
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
