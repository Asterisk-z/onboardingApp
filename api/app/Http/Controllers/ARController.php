<?php

namespace App\Http\Controllers;

use App\Events\ArAddedEvent;
use App\Helpers\ARMailContents;
use App\Helpers\MailContents;
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
use App\Models\ArCreationRequest;
use App\Models\ArsToBeCreatedOnSystem;
use App\Models\AR\ARDeactivationRequest;
use App\Models\AR\ARTransferRequest;
use App\Models\FmdqSystems;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class ARController extends Controller
{
    public function listMEG(Request $request)
    {
        $query = User::whereNotNull('institution_id');

        if ($request->institution_id) {
            $query = $query->where('institution_id', $request->institution_id);
        }

        if ($request->approval_status) {
            $query = $query->where('approval_status', strtolower($request->approval_status));
        }

        if ($request->role_id) {
            $query = $query->where('role_id', $request->role_id);
        }

        $users = $query->latest()->get();

        return successResponse('Successful', UserResource::collection($users));
    }

    public function listReportMEG(Request $request)
    {
        $query = User::whereNotNull('institution_id');

        if ($request->institution_id) {
            $query = $query->where('institution_id', $request->institution_id);
        }

        if ($request->approval_status) {
            $query = $query->where('approval_status', strtolower($request->approval_status));
        }

        if ($request->role_id) {
            $query = $query->where('role_id', $request->role_id);
        }

        $users = $query->latest()->get();

        return successResponse('Successful', ['report' => UserResource::collection($users), 'report_url' => route('downloadReport', ['representation_report'])]);
    }

    public function list(Request $request)
    {
        $query = User::where('institution_id', $request->user()->institution_id);

        if ($request->approval_status) {
            $query = $query->where('approval_status', strtolower($request->approval_status));
        }

        if ($request->role_id) {
            $query = $query->where('role_id', $request->role_id);
        }

        if ($request->update_payload) {
            $query = $query->whereNotNull('update_payload');
        }

        $users = $query->latest()->get();

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
        $validated['img'] = $request->hasFile('img') ? $request->file('img')->storePublicly('users', 'public') : null;
        $validated['mandate_form'] = $request->hasFile('mandate_form') ? $request->file('mandate_form')->storePublicly('mandate', 'public') : null;
        // return "tes";
        $user = User::create($validated);

        $regID = $user->createRegIDAr();

        $logMessage = "Added a new AR - $user->email ($regID)";
        logAction($request->user()->email, 'Add AR', $logMessage, $request->ip());

        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
        $BLGs = Utility::getUsersEmailByCategory(Role::BLG);

        $CCs = array_merge($MBGs, $BLGs);

        $MEGs = Utility::getUsersByCategory(Role::MEG);

        if (count($MEGs)) {
            Notification::send($MEGs, new InfoNotification(ARMailContents::applicationMEGBody($user), ARMailContents::applicationMEGSubject(), $CCs));
        }

        event(new ArAddedEvent($request->user()->institution_id, $user));

        return successResponse('Successful', UserResource::make($user));
    }

    public function processAddByMEG(Request $request, User $ARUser)
    {

        if ($ARUser->approval_status != User::PENDING) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "This AR is already approved or declined.");
        }

        $request->validate([
            'action' => 'required|in:approve,decline',
        ]);

        $regID = $ARUser->getRegID();

        if ($request->action == 'approve') {

            // Generate another password so it can be sent via email
            $password = Utility::generatePassword();
            $ARUser->approval_status = User::APPROVED;
            $ARUser->approval_status_by = $request->user()->id;
            $ARUser->password = Hash::make($password);

            $ARUser->save();

            $logTitle = 'Approve New AR';
            $logMessage = "Approved the addition of AR - $ARUser->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

            $ARUser->notify(new InfoNotification(ARMailContents::approvedARBody($ARUser, $password), ARMailContents::approvedARSubject()));
        } else {

            $ARUser->approval_status = User::DECLINED;
            $ARUser->approval_status_by = $request->user()->id;
            $ARUser->save();

            $logTitle = 'Decline New AR';
            $logMessage = "Declined the addition of AR - $ARUser->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
        }

        return successResponse('Successful', UserResource::make($ARUser));
    }

    public function update(UpdateARRequest $request, User $ARUser)
    {
        $validated = $request->validated();
        $authoriserID = $validated['ar_authoriser_id'];

        if ($authoriserID == $ARUser->id) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'The AR being edited can not be used as the authoriser');
        }
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

        if ($ARUser->position_id != $request->position_id) {
            if (User::where('position_id', $request->position_id)->where('institution_id', auth()->user()->institution_id)->where('member_status', 'active')->exists()) {
                return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Another User has the same position.');
            }
        }

        $validated['img'] = $request->hasFile('img') ? $request->file('img')->storePublicly('users', 'public') : $ARUser->img;
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

        $regID = $ARUser->getRegID();
        $logMessage = "Updated the AR record of - $ARUser->email ($regID)";
        logAction($request->user()->email, 'Update AR', $logMessage, $request->ip());

        $authoriserUser = User::find($authoriserID);
        $authoriserUser->notify(new InfoNotification(ARMailContents::updateAuthoriserBody($ARUser), ARMailContents::updateAuthoriserSubject()));

        return successResponse('Successful', UserResource::make($ARUser));
    }

    public function cancelUpdate(Request $request, User $ARUser)
    {

        if ($ARUser->update_authoriser_id || $ARUser->update_payload) {
            $ARUser->update_authoriser_id = null;
            $ARUser->update_payload = null;
            $ARUser->save();

            $regID = $ARUser->getRegID();
            $logMessage = "Cancelled the AR update of $ARUser->email ($regID)";
            logAction($request->user()->email, 'Cancel AR Update', $logMessage, $request->ip());
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

        $regID = $ARUser->getRegID();

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

            $updateParams = $data;

            // if position is set, remove it from update data
            if (isset($data['position'])) {
                unset($data['position']);
            }

            // if role is set, remove it from update data
            if (isset($data['role'])) {
                unset($data['role']);
            }

            $oldRecord = $ARUser->replicate();

            $ARUser->update($data);

            $logTitle = 'Approve AR Update';
            $logMessage = "Approved the AR update of $ARUser->email ($regID)";

            $MEGs = Utility::getUsersByCategory(Role::MEG);
            if (count($MEGs)) {
                Notification::send($MEGs, new InfoNotification(ARMailContents::updatedMEGBody($oldRecord, $updateParams), ARMailContents::updatedMEGSubject()));
            }

        } else {
            $logTitle = 'Decline AR Update';
            $logMessage = "Declined the AR update of $ARUser->email ($regID)";
        }

        $ARUser->update_authoriser_id = null;
        $ARUser->update_payload = null;
        $ARUser->save();

        logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

        return successResponse('Successful', UserResource::make($ARUser));
    }

    public function listTransfer(Request $request)
    {
        // check if there is pending transfer request
        $query = ARTransferRequest::where('new_institution_id', $request->user()->institution_id);

        if ($request->status) {
            $query = $query->where('approval_status', $request->status);
        }

        $records = $query->latest()->get();

        return successResponse('Successful', ARTransferRequestResource::collection($records));
    }

    public function listTransferMEG(Request $request)
    {
        // check if there is pending transfer request
        $query = ARTransferRequest::whereNotNull('new_institution_id');

        if ($request->status) {
            $query = $query->where('approval_status', $request->status);
        }

        if ($request->meg_status) {
            $query = $query->where('mbg_approval_status', $request->status);
        }

        $records = $query->latest()->get();

        return successResponse('Successful', ARTransferRequestResource::collection($records));
    }

    public function listStatusChange(Request $request)
    {
        $institution_id = $request->user()->institution_id;

        $query = ARDeactivationRequest::whereHas('ar', function ($subQuery) use ($institution_id) {
            // Use the relationship to filter based on institution ID
            $subQuery->where('institution_id', $institution_id);
        });

        // Check if there is a specific approval status in the request
        if ($request->status) {
            $query = $query->where('approval_status', $request->status);
        }

        $records = $query->latest()->get();

        return successResponse('Successful', ARDeactivationRequestResource::collection($records));
    }

    public function transfer(TransferARRequest $request, User $ARUser)
    {
        $validated = $request->validated();

        // check if there is pending transfer request
        $existingRecord = ARTransferRequest::where('ar_user_id', $ARUser->id)
            ->where('new_institution_id', $request->user()->institution_id)
            ->where('approval_status', ARTransferRequest::PENDING)
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

        $regID = $ARUser->getRegID();
        $logMessage = "Requested AR transfer of $ARUser->email ($regID)";
        logAction($request->user()->email, 'Request AR Transfer', $logMessage, $request->ip());

        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);

        $authoriserUser = User::find($authoriserID);
        $authoriserUser->notify(new InfoNotification(ARMailContents::transferAuthoriserBody($ARUser), ARMailContents::transferAuthoriserSubject(), $MEGs));

        $record->refresh();

        return successResponse('Successful', ARTransferRequestResource::make($record));
    }

    public function processTransfer(Request $request, ARTransferRequest $record)
    {
        $request->validate([
            'action' => 'required|in:approve,decline',
            'reason' => 'nullable',
        ]);

        if ($record->authoriser_id != $request->user()->id) {
            return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "You are not allowed to perform this action");
        }

        if ($record->approval_status != ARDeactivationRequest::PENDING) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'This request has already been approved or declined');
        }

        $ARUser = $record->ar;
        $regID = $ARUser->getRegID();

        if ($request->action == 'decline') {

            $record->approval_status = ARTransferRequest::DECLINED;
            $record->approval_reason = $request->reason;
            $record->save();

            $logTitle = 'Decline AR Transfer';
            $logMessage = "Declined the transfer of AR - $ARUser->email ($regID). Request ref #$record->id";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

            // send mail
            $MEGs = Utility::getUsersEmailByCategory(Role::MEG);

            $ARRequester = $record->requester;
            $ARRequester->notify(new InfoNotification(ARMailContents::transferDeclineRequesterBody($ARUser, $request->reason), ARMailContents::transferDeclineRequesterSubject(), [ ...$MEGs, $request->user()->email]));

            return successResponse('Successful', ARTransferRequestResource::make($record));
        } else {

            $record->approval_status = ARTransferRequest::APPROVED;
            $record->mbg_approval_status = ARTransferRequest::PENDING;
            $record->approval_reason = $request->reason;
            $record->save();

            $record->refresh(); // reload the ar relationship

            $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
            $BLGs = Utility::getUsersEmailByCategory(Role::BLG);

            $CCs = array_merge($MBGs, $BLGs);

            $MEGs = Utility::getUsersByCategory(Role::MEG);
            if (count($MEGs)) {
                Notification::send($MEGs, new InfoNotification(ARMailContents::transferApprovedMEGBody($ARUser), ARMailContents::transferApprovedMEGSubject(), $CCs));
            }

            $logTitle = 'Approve AR Transfer';
            $logMessage = "Approved the transfer of AR - $ARUser->email ($regID). Request ref #$record->id";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
        }

        return successResponse('Successful', ARTransferRequestResource::make($record));
    }

    public function processTransferByMEG(Request $request, ARTransferRequest $record)
    {
        $request->validate([
            'action' => 'required|in:approve,decline',
        ]);

        if ($record->mbg_approval_status != ARDeactivationRequest::PENDING) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'This request has already been approved or declined');
        }

        if ($record->approval_status != ARDeactivationRequest::APPROVED) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'This request has not been authorised.');
        }

        $ARUser = $record->ar;
        $regID = $ARUser->getRegID();

        if ($request->action == 'decline') {

            $record->mbg_approval_status = ARTransferRequest::DECLINED;
            $record->save();

            $logTitle = 'MBG Decline AR Transfer';
            $logMessage = "Declined the transfer of AR - $ARUser->email ($regID). Request ref #$record->id";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

            // send mail

            $ARRequester = $record->requester;
            $ARRequester->notify(new InfoNotification(ARMailContents::transferDeclineRequesterBody($ARUser, $request->reason), ARMailContents::transferDeclineRequesterSubject(), [$request->user()->email]));

            return successResponse('Successful', ARTransferRequestResource::make($record));
        } else {

            $data = [];
            if ($record->update_payload) {
                // Update the user
                $data = $record->update_payload;

                if (is_string($data)) {
                    // Convert the string to an array if needed
                    $data = json_decode($data, true);
                }

                if (isset($data['email'])) {
                    if (User::where('email', $data['email'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                        return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Transfer failed. The email has already been taken.');
                    }
                }

                if (isset($data['phone'])) {
                    if (User::where('phone', $data['phone'])->where('is_del', false)->where('id', '!=', $ARUser->id)->exists()) {
                        return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Transfer failed. The phone has been taken.');
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
            }

            $data['institution_id'] = $record->new_institution_id;
            $ARUser->update($data);

            $record->mbg_approval_status = ARTransferRequest::APPROVED;
            $record->save();

            $record->refresh(); // reload the ar relationship

            $logTitle = 'MBG Approve AR Transfer';
            $logMessage = "MBG approved the transfer of AR - $ARUser->email ($regID). Request ref #$record->id";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
        }

        return successResponse('Successful', ARTransferRequestResource::make($record));
    }

    public function changeStatus(ChangeStatusARRequest $request, User $ARUser)
    {
        $validated = $request->validated();

        // check if there is pending transfer request
        $existingRecord = ARDeactivationRequest::where('ar_user_id', $ARUser->id)
            ->where('approval_status', ARDeactivationRequest::PENDING)
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

        $regID = $ARUser->getRegID();

        $logActionType = ($validated['request_type'] == "activate") ? "Activation" : "Deactivation";

        $logMessage = "Requested AR $logActionType of $ARUser->email ($regID)";
        logAction($request->user()->email, "Request AR $logActionType", $logMessage, $request->ip());

        $authoriserUser = User::find($authoriserID);
        $authoriserUser->notify(new InfoNotification(ARMailContents::changeStatusAuthoriserBody($ARUser, $logActionType), ARMailContents::changeStatusAuthoriserSubject($logActionType)));

        return successResponse('Successful', ARDeactivationRequestResource::make($record));
    }

    public function processChangeStatus(Request $request, ARDeactivationRequest $record)
    {
        $request->validate([
            'action' => 'required|in:approve,decline',
            'reason' => 'nullable',
        ]);

        if ($record->authoriser_id != $request->user()->id) {
            return errorResponse(ResponseStatusCodes::UNAUTHORIZED, "You are not allowed to perform this action");
        }

        if ($record->approval_status != ARDeactivationRequest::PENDING) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'This request has already been approved or declined');
        }

        $logActionType = ($record->request_type == ARDeactivationRequest::REQUEST_TYPE_ACTIVATE) ? "Activation" : "Deactivation";

        $ARUser = $record->ar;
        $regID = $ARUser->getRegID();

        if ($request->action == 'decline') {

            $record->approval_status = ARDeactivationRequest::DECLINED;
            $record->approval_reason = $request->reason;
            $record->save();

            $logTitle = 'Decline AR ' . $logActionType;
            $logMessage = "Declined the $logActionType of AR - $ARUser->email ($regID). Request ref #$record->id";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
            return successResponse('Successful', ARDeactivationRequestResource::make($record));
        } else {

            // Activate or deactivate the user
            $ARUser->is_active = ($record->request_type == ARDeactivationRequest::REQUEST_TYPE_ACTIVATE) ? '1' : '0';
            // $ARUser->member_status = ($record->request_type == ARDeactivationRequest::REQUEST_TYPE_ACTIVATE) ? "active" : "suspended";
            $ARUser->save();

            $record->approval_status = ARDeactivationRequest::APPROVED;
            $record->approval_reason = $request->reason;
            $record->save();

            $record->refresh(); // reload the ar relationship

            $mailSubject = $mailBody = "";

            // Notify MEG
            if ($record->request_type == ARDeactivationRequest::REQUEST_TYPE_ACTIVATE) {
                $mailSubject = ARMailContents::activationMEGSubject();
                $mailBody = ARMailContents::activationMEGBody($ARUser);
            } else {
                $mailSubject = ARMailContents::deactivationMEGSubject();
                $mailBody = ARMailContents::deactivationMEGBody($ARUser);
            }

            $MEGs = Utility::getUsersByCategory(Role::MEG);
            if (count($MEGs)) {
                Notification::send($MEGs, new InfoNotification($mailBody, $mailSubject));
            }

        }

        return successResponse('Successful', ARDeactivationRequestResource::make($record));
    }

    public function getArCreationRequest(Request $request)
    {

        $ar_creation_request = ArCreationRequest::where('submitted_by', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        return successResponse("Here you go", $ar_creation_request);
    }

    public function arCreationRequest(Request $request)
    {
        $request->validate([
            'system_id' => 'required|exists:fmdq_systems,id',
            'ars' => 'required|array',
            'ars.*' => 'required|exists:users,id',
        ]);

        $data = [];
        $user = $request->user();

        $system = FmdqSystems::find($request->system_id);

        $creationRequest = ArCreationRequest::create([
            'system_id' => $system->id,
            'next_office' => 'MBG',
            'submitted_by' => $user->id,
        ]);

        $ars = $request->ars;

        foreach ($ars as $key => $ar) {

            $data[] = [
                'ar_id' => $ar,
                'ar_creation_request_id' => $creationRequest->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ArsToBeCreatedOnSystem::insert($data);

        $MBGs = Utility::getUsersByCategory(Role::MBG);
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $MSGs = Utility::getUsersEmailByCategory(Role::MSG);
        $CCs = array_merge($MSGs, $MEGs);
        Notification::send($MBGs, new InfoNotification(MailContents::profileArSystemMail("{$user->first_name} {$user->last_name} $user->middle_name", $system->name), MailContents::profileArSystemSubject($system->name), $CCs));
        logAction($user->email, 'AR created requested', "A member requested that ARs be added on a system", $request->ip());

        return successResponse('Request sent successfully');
    }

    public function processMemberStatusMEG(Request $request, User $ARUser)
    {

        $request->validate([
            'action' => 'required|in:approve,suspend',
        ]);

        $regID = $ARUser->getRegID();

        if ($request->action == 'approve') {

            $ARUser->member_status = 'active';
            $ARUser->save();

            $logTitle = 'Activate Member';
            $logMessage = auth()->user()->full_name . " activated member status of AR - $ARUser->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());

        } else {

            $ARUser->member_status = 'suspended';
            $ARUser->save();

            $logTitle = 'Suspend Member';
            $logMessage = auth()->user()->full_name . " suspended  member status of AR - $ARUser->email ($regID)";
            logAction($request->user()->email, $logTitle, $logMessage, $request->ip());
        }

        return successResponse('Status Updated Successful', []);
    }
}
