<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\AR\AddARRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ARController extends Controller
{
    public function addAR(AddARRequest $request)
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
}
