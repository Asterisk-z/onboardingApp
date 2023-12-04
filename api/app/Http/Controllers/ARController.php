<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Requests\AR\AddARRequest;
use App\Http\Requests\AR\SearchARRequest;
use App\Http\Requests\AR\UpdateARRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ARController extends Controller
{


    public function list(Request $request)
    {

        $query = User::where('institution_id', $request->user()->institution_id);

        if ($request->approval_status) {
            $query = $query->where('approval_status', strtolower($request->approval_status));
        }

        if ($request->role_id) {
            $query = $query->where('role_id', $request->role_id);
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

    public function view(Request $request, User $ARUser)
    {
        return successResponse('Successful', UserResource::make($ARUser));
    }


    public function add(AddARRequest $request)
    {
        $validated = $request->validated();
        $validated['institution_id'] = $request->user()->institution_id;

        $password = Utility::generatePassword();
        $validated['password'] = \Hash::make($password);
        $validated['created_by'] = $request->user()->id;


        $user = User::create($validated);

        //TODO::SEND MAIL to user and MEG for approval

        return successResponse('Successful', UserResource::make($user));
    }

    public function update(UpdateARRequest $request, User $ARUser)
    {
        $validated = $request->validated();


        $authoriserID = $validated['ar_authoriser_id'];

        if ($authoriserID == $ARUser->id) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'The AR being edited can not be used as the authoriser');
        }

        if ($authoriserID == $request->user()->id) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'You can not be used as the authoriser');
        }

        if (isset($validated['email'])) {
            if (User::where('email', $validated['email'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'The email has been taken by another user.');
            }
        }

        if (isset($validated['phone'])) {
            if (User::where('phone', $validated['phone'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'The phone has been taken by another user.');
            }
        }

        unset($validated['ar_authoriser_id']);

        $ARUser->update_authoriser_id = $authoriserID;
        $ARUser->update_payload = $validated;
        $ARUser->save();

        //TODO::SEND MAIL to MEG for approval

        return successResponse('Successful', UserResource::make($ARUser));

    }

}
