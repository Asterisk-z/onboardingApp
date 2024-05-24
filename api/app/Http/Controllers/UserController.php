<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\StakeHolderAccessRequest;
use App\Models\User;
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

            $user = User::firstOrCreate(['email'  => request('email')], User::STAKEHOLDER_DATA(request('email')));

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
