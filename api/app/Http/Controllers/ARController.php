<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Requests\AR\AddARRequest;
use App\Http\Requests\AR\ChangeStatusARRequest;
use App\Http\Requests\AR\SearchARRequest;
use App\Http\Requests\AR\TransferARRequest;
use App\Http\Requests\AR\UpdateARRequest;
use App\Http\Resources\AR\ARDeactivationRequestResource;
use App\Http\Resources\AR\ARTransferRequestResource;
use App\Http\Resources\UserResource;
use App\Models\AR\ARDeactivationRequest;
use App\Models\AR\ARTransferRequest;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $validated['password'] = Hash::make($password);
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

        // if position_id is set, add to json
        if (isset($validated['position_id'])) {
            $position = Position::find($validated['position_id']);
            $validated['position'] = [
                'id' => $position->id,
                'name' => $position->name,
            ];
        }

        // if role_id is set, add to json
        if (isset($validated['role_id'])) {
            $role = Role::find($validated['role_id']);
            $validated['role'] = [
                'id' => $role->id,
                'name' => $role->name,
            ];
        }

        $ARUser->update_authoriser_id = $authoriserID;
        $ARUser->update_payload = $validated;
        $ARUser->save();

        //TODO::SEND MAIL to authoriser for approval

        return successResponse('Successful', UserResource::make($ARUser));

    }

    public function cancelUpdate(User $ARUser)
    {

        if ($ARUser->update_authoriser_id || $ARUser->update_payload) {
            $ARUser->update_authoriser_id = null;
            $ARUser->update_payload = null;
            $ARUser->save();

            //TODO::SEND MAIL to authoriser for approval
        }

        return successResponse('Successful', UserResource::make($ARUser));

    }

    public function processUpdate(Request $request, User $ARUser)
    {
        if ($ARUser->update_authoriser_id != $request->user()->id) {
            return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "You are not allowed to perform this action");
        }

        $request->validate([
            'action' => 'required|in:approve,decline',
        ]);

        if ($request->action == 'approve') {
            $data = $ARUser->update_payload;

            if (is_string($data)) {
                // Convert the string to an array if needed
                $data = json_decode($data, true);
            }

            if (isset($data['email'])) {
                if (User::where('email', $data['email'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                    return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Update failed. The email has already been taken.');
                }
            }

            if (isset($data['phone'])) {
                if (User::where('phone', $data['phone'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                    return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Update failed. The phone has been taken.');
                }
            }




            // if position is set, remove it from update data
            if (isset($data['position'])) {
                unset($data['position']);
            }

            // if role is set, remove it from update data
            if (isset($data['role'])) {
                unset($data['role']);
            }

            $ARUser->update($data);
        }

        $ARUser->update_authoriser_id = null;
        $ARUser->update_payload = null;
        $ARUser->save();

        return successResponse('Successful', UserResource::make($ARUser));

    }


    public function transfer(TransferARRequest $request, User $ARUser)
    {
        $validated = $request->validated();

        // check if there is pending transfer request
        $existingRecord = ARTransferRequest::where('ar_user_id', $ARUser->id)
            ->where('new_institution_id', $request->user()->institution_id)
            ->where('approval_status', 'pending')
            ->first();

        if ($existingRecord) {
            return errorResponse(ResponseStatusCodes::DUPLICATE_REQUEST, 'There is a pending transfer request for this AR', ARTransferRequestResource::make($existingRecord));
        }


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


        // if position_id is set, add to json
        if (isset($validated['position_id'])) {
            $position = Position::find($validated['position_id']);
            $validated['position'] = [
                'id' => $position->id,
                'name' => $position->name,
            ];
        }

        // if role_id is set, add to json
        if (isset($validated['role_id'])) {
            $role = Role::find($validated['role_id']);
            $validated['role'] = [
                'id' => $role->id,
                'name' => $role->name,
            ];
        }

        $reason = null;


        // remove unneeded data
        unset($validated['ar_authoriser_id']);
        if (isset($validated['reason'])) {
            $reason = $validated['reason'];
            unset($validated['reason']);
        }

        $record = new ARTransferRequest();
        $record->ar_user_id = $ARUser->id;
        $record->requester_user_id = $request->user()->id;
        $record->authoriser_id = $authoriserID;
        $record->update_payload = json_encode($validated);
        $record->new_institution_id = $request->user()->institution_id;
        $record->request_reason = $reason;
        $record->save();

        //TODO::SEND MAIL to authoriser for approval

        $record->refresh();


        return successResponse('Successful', ARTransferRequestResource::make($record));

    }

    public function changeStatus(ChangeStatusARRequest $request, User $ARUser)
    {
        $validated = $request->validated();

        // check if there is pending transfer request
        $existingRecord = ARDeactivationRequest::where('ar_user_id', $ARUser->id)
            ->where('approval_status', 'pending')
            ->first();

        if ($existingRecord) {
            return errorResponse(ResponseStatusCodes::DUPLICATE_REQUEST, 'There is a pending ' . $existingRecord->request_type . ' request for this AR.', ARDeactivationRequestResource::make($existingRecord));
        }


        $authoriserID = $validated['ar_authoriser_id'];

        if ($authoriserID == $ARUser->id) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'The AR being edited can not be used as the authoriser');
        }

        if ($authoriserID == $request->user()->id) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'You can not be used as the authoriser');
        }


        $record = new ARDeactivationRequest();
        $record->ar_user_id = $ARUser->id;
        $record->requester_user_id = $request->user()->id;
        $record->authoriser_id = $authoriserID;
        $record->request_type = $validated['request_type'];
        $record->request_reason = $validated['reason'];
        $record->save();


        $record->refresh();

        //TODO::SEND MAIL to authoriser for approval

        return successResponse('Successful', ARDeactivationRequestResource::make($record));

    }
}
