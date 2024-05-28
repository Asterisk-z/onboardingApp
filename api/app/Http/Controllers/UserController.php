<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\StakeHolderAccessRequest;
use App\Models\User;
use App\Rules\EmailValidation;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_ar_authorisers()
    {
        $users = User::where('is_del', '0')->where('institution_id', auth()->user()->institution_id)->where('role_id', Role::ARAUTHORISER)->orderBy('first_name', 'DESC')->get();
        $converted_users = Utility::arrayKeysToCamelCase($users);

        $data = [
            'users' => (array) $converted_users,
        ];
        return successResponse('Authorisers Fetched Successfully', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stakeholder_request(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'access' => ['required', 'string'],
        ]);

        if (!$access = StakeHolderAccessRequest::where('email', request('email'))->where('access', request('access'))->first()) {

            StakeHolderAccessRequest::create([
                'email' => request('email'),
                'access' => request('access'),
            ]);

            $user = User::firstOrCreate(['email' => request('email')], User::STAKEHOLDER_DATA(request('email')));

            logAction($user->email, 'Stake Holder Request Access to ' . request('access'), 'Access Request', $request->ip());

            return errorResponse(ResponseStatusCodes::BAD_REQUEST, "Access Request Sent for approval.");

        }

        if ($access->status == StakeHolderAccessRequest::APPROVED) {

            $user = User::firstOrCreate(['email' => request('email')], User::STAKEHOLDER_DATA(request('email')));

            if ($user) {
                $data = [
                    'authorization' => [
                        'type' => 'Bearer',
                        'token' => loginAuth()->fromUser($user),
                        'expires_in' => config('jwt.ttl') * 60,
                    ],
                    'user' => UserResource::make($user),
                ];

                logAction($user->email, 'Stake Holder Login successful', 'Login Successful', $request->ip());
                return successResponse("Access Granted.", $data);

            }

        }

        logAction(request('email'), 'Access Not Granted', 'Access Request', $request->ip());
        return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Access Not Granted');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_stakeholders()
    {
        $users = User::where('role_id', Role::STAKEHOLDER)->orderBy('first_name', 'DESC')->get();
        $converted_users = Utility::arrayKeysToCamelCase($users);

        $data = [
            'users' => (array) $converted_users,
        ];
        return successResponse('Stakeholders Fetched Successfully', $data);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_active_stakeholders()
    {
        $users = User::where('is_del', '0')->where('role_id', Role::STAKEHOLDER)->orderBy('first_name', 'DESC')->get();
        $converted_users = Utility::arrayKeysToCamelCase($users);

        $data = [
            'users' => (array) $converted_users,
        ];
        return successResponse('Stakeholders Fetched Successfully', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            "firstName" => "required|string",
            "lastName" => "required|string",
            "email" => [
                'email',
                'required',
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->where('is_del', false)->exists()) {
                        $fail('The email has been taken.');
                    }
                },
                new EmailValidation,
            ],
        ]);

        $user = auth()->user();

        User::create(User::STAKEHOLDER_DATA(request('email'), request('firstName'), request('lastName')));

        $logMessage = $user->email . ' created a stake holder : ' . $request->email;
        logAction($user->email, 'New Stake Holder Created', $logMessage, $request->ip());

        return successResponse('New Stake Holder Created', []);

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

        $user = User::find($id);
        if (!$user) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'User Does not exist');
        }
        //
        $validated = $request->validate([
            "firstName" => "required|string",
            "lastName" => "required|string",
            "email" => [
                'sometimes',
                'email',
                new EmailValidation,
            ],
        ]);
        //

        $user->update([
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
        ]);

        $logMessage = auth()->user()->email . ' updated a stake holder : ' . $request->email;
        logAction(auth()->user()->email, 'Stake Holder Updated', $logMessage, $request->ip());

        return successResponse('Update successful', []);

    }

    public function updateStatus(Request $request, $id)
    {

        $validated = $request->validate([
            "status" => "required|string|in:approved,declined",
        ]);
        //
        $user = User::find($id);
        if (!$user) {
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'Does not exist');
        }

        if ($request->status == 'approved') {

            $user->update([
                'approval_status' => $request->status,
                'is_del' => 0,
            ]);

        }

        if ($request->status == 'declined') {

            $user->update([
                'approval_status' => $request->status,
                'is_del' => 1,
            ]);

        }

        return successResponse('Update successful', $user);
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
