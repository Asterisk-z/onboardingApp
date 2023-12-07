<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\Audit;
use App\Models\Institution;
use App\Models\InstitutionMembership;
use App\Models\MembershipCategory;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Notifications\InfoNotification;
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

        if (!$user = User::where('email', $request->email)->first()) {
            logAction($request->email, 'Failed Login', 'Failed Login - Incorrect Email', $request->ip());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            logAction($request->email, 'Failed Login', 'Failed Login - Incorrect Password', $request->ip());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        //check if user is verified, force if otherwise.
        if (!$user->verified_at) {
            logAction($request->email, 'Failed Login', 'Failed Login - Not yet reset password', $request->ip());
            return errorResponse(ResponseStatusCodes::FORCE_PASSWORD_RESET, "Please reset your password to continue.");
        }

        //check password policy
        if (!Utility::checkPasswordExpiry($user)) {
            logAction($request->email, 'Failed Login', 'Failed Login - Password expired', $request->ip());
            return errorResponse(ResponseStatusCodes::FORCE_PASSWORD_RESET, "In a bid to keep you safe, you are required to reset your password.");
        }

        $token = auth()->login($user);
        $data = [
            'authorization' => [
                'type' => 'Bearer',
                'token' => $token,
                'expires_in' => config('jwt.ttl') * 60
            ],
            'user' => UserResource::make($user),
        ];

        logAction(auth()->user()->email, 'Successful Login', 'Login Successfull', $request->ip());

        return successResponse('Login Successful', $data);
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $institution = Institution::create();
        $position = Position::first();

        InstitutionMembership::create([
            'institution_id' => $institution->id,
            'membership_category_id' => $request->input('category'),
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
            'position_id' => $position ? $position->id : null,
            'verified_at' => now()
        ]);

        $user->passwords()->create([
            'password' => Hash::make($request->input('password'))
        ]);

        logAction($request->email, 'Successful User Registration', 'Registration Successful', $request->ip());

        $membership = MembershipCategory::find($request->input('category'));

        $user->notify(new InfoNotification(MailContents::signupMail($user->email, $user->created_at->format('Y-m-d')), MailContents::signupMailSubject()));
        return successResponse("You have successfully signed up as a" . $membership ? $membership->name : "member" . ". Kindly check your mail to proceed with completion of the membership form", UserResource::make($user));
    }
}
