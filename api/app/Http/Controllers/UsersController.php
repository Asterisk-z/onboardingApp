<?php

namespace App\Http\Controllers;

use App\Helpers\MailContents;
use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\Application;
use App\Models\Institution;
use App\Models\InstitutionMembership;
use App\Models\MembershipCategory;
use App\Models\PasswordSet;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Notifications\InfoNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required|string',
        // ]);

        if (!$user = User::where('email', $request->email)->first()) {
            logAction($request->email, 'Failed Login', 'Failed Login - Incorrect Email', $request->ip());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            logAction($request->email, 'Failed Login', 'Failed Login - Incorrect Password', $request->ip());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!$user->is_active) {
            logAction($request->email, 'Failed Login', 'Failed Login - Account Suspended', $request->ip());
            return errorResponse(ResponseStatusCodes::ACCOUNT_SUSPENDED, "Account Suspended.");
        }

        //check if user is verified, force if otherwise.
        if (!$user->verified_at) {
            logAction($request->email, 'Failed Login', 'Failed Login - Not yet reset passwword', $request->ip());
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
                'expires_in' => config('jwt.ttl') * 60,
            ],
            'user' => UserResource::make($user),
        ];

        logAction(auth()->user()->email, 'Successful Login', 'Login Successfull', $request->ip());

        return successResponse('Login Successful', $data);
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $institution = Institution::create();

        InstitutionMembership::create([
            'institution_id' => $institution->id,
            'membership_category_id' => $request->input('category'),
        ]);

        $user = User::create([
            'first_name' => $request->input('firstName'),
            'last_name' => $request->input('lastName'),
            'middle_name' => $request->input('middleName') ?? null,
            'nationality' => $request->input('nationality'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'approval_status' => 'approved',
            'role_id' => Role::ARINPUTTER,
            'institution_id' => $institution->id,
            'category_id' => $request->input('category'),
            'position_id' => $request->input('position'),
            'img' => $request->hasFile('img') ? $request->file('img')->storePublicly('users', 'public') : null,
            'verified_at' => now(),
        ]);

        $signature = Str::random(30);

        PasswordSet::create([
            "email" => $user->email,
            "signature" => $signature,
        ]);

        $status = new Status();
        $status->office = Application::office['AP'];
        $status->status = Application::statuses['PEN'];
        $status->save();

        $application = Application::create([
            'institution_id' => $institution->id,
            'disclosure_stage' => 1,
            'submitted_by' => $user->id,
            'membership_category_id' => $request->input('category'),
            'status' => $status->id,
            'office_to_perform_next_action' => Application::office['AP'],
            'application_type' => Application::type['APP'],
            'application_type_status' => Application::typeStatus['ASP'],
        ]);

        $application->status()->save($status);

        $user->getRegID();

        logAction($request->email, 'Successful User Registration', 'Registration Successful', $request->ip());

        $membership = MembershipCategory::find($request->input('category'));

        $user->notify(new InfoNotification(MailContents::signupMail($user->email, $user->created_at->format('Y-m-d'), crypt::encrypt($signature)), MailContents::signupMailSubject()));

        $MEGs = Utility::getUsersByCategory(Role::MEG);
        if (count($MEGs)) {
            Notification::send($MEGs, new InfoNotification(MailContents::newMembershipSignupMail($user->first_name . " " . $user->last_name, $membership->name ?? null), MailContents::newMembershipSignupSubject()));
        }

        $membership = $membership ? Utility::categoryNameWithPronoun($membership->name) : "a member";
        return successResponse("You have successfully signed up as $membership. Kindly check your mail to proceed with completion of the membership form", UserResource::make($user));
    }
}
