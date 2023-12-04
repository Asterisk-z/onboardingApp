<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\AR\AddARRequest;
use App\Http\Requests\AR\SearchARRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ARController extends Controller
{
    public function add(AddARRequest $request)
    {


        $validated = $request->validated();
        $validated['institution_id'] = $request->user()->institution_id;

        $password = Utility::generatePassword();
        $validated['password'] = \Hash::make($password);
        $validated['created_by'] = $request->user()->id;


        $user = User::create($validated);

        //TODO::SEND MAIL to user and admin for approval

        return successResponse('Successful', UserResource::make($user));


    }

    public function list(Request $request)
    {

        $query = User::where('institution_id', $request->user()->institution_id);

        if ($request->approval_status) {
            $query = $query->where('approval_status', strtolower($request->approval_status));
        }

        $users = $query->get();

        return successResponse('Successful', UserResource::collection($users));
    }

    public function search(SearchARRequest $request)
    {

        $users = User::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->get();


        return successResponse('Successful', UserResource::collection($users));
    }
}
