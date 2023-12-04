<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\Institution;
use App\Models\InstitutionMembership;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(! $user = User::where('email', $request->email)->first()){
            return errorResponse("99", "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if(! Hash::check($request->password, $user->password)){
            return errorResponse("99", "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->login($user);
        $data = [
            'authorization' => [
                'type' => 'Bearer',
                'token' =>  $token,
                'expires_in'=>  config('jwt.ttl') * 60
            ],
            'user' => UserResource::make($user)
        ];

        return successResponse('Login Successful', $data);
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $institution = Institution::create();
        $position = Position::first();

        InstitutionMembership::create([
            'institution_id' => $institution->id,
            'membership_category_id' => $request->input('category')
        ]);
        
        $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'nationality' => $request->input('nationality'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'approval_status' => 'approved',
            'role_id' => Role::ARINPUTTER,
            'institution_id' => $institution->id,
            'position_id' => $position ? $position->id : null
        ]);

        //TODO::SEND MAIL ??? 

        return successResponse('Registration Successful', UserResource::make($user));
    }
}
