<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseStatusCodes;
use App\Helpers\Utility;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!Hash::check($request->input('password'), $user->password)) {
            logAction($request->input('email'), 'Change Password Failed', 'Change Password Failed - Incorrect Password', $request->ip());
            return errorResponse(ResponseStatusCodes::INVALID_AUTH_CREDENTIAL, "Invalid password.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!Utility::checkPasswordPolicy($user, $request->input('new_password'))) {
            logAction($request->input('email'), 'Change Password Failed', 'Change Password Failed - Failed password policy', $request->ip());
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'To keep you safe, you are not permitted to use a password you have used in the last ' . config('app.unique_password') . ' Months');
        }

        $user->passwords()->create([
            'password' => Hash::make($request->input('new_password')),
        ]);

        $user->password = Hash::make($request->input('new_password'));
        $user->verified_at = now();
        $user->save();

        logAction($user->email, 'Password reset', 'Successfully reset password', $request->ip());
        return successResponse('Password reset successfully. Login to continue');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        try {
            $response = (new OtpService)->generateOtp($user);

            if ($response && $response['success'] == true && $response['status'] == 'generated') {
                logAction($user->email, 'OTP Generation successful', 'OTP Generation successful', $request->ip());
                return successResponse('Enter the OTP sent to your email address');
            } else {
                logAction($user->email, 'OTP Generation failed', 'Unable to complete your request', $request->ip());
                return errorResponse();
            }
        } catch (\Throwable $th) {
            logger($th);
            logAction($user->email, 'OTP Generation failed', 'Unable to complete your request', $request->ip());
            return errorResponse();
        }

    }

    public function validateForgotPasswordOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|min:4|max:6',
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $response = (new OtpService)->verifyOtp($user, $request->otp);

        if ($response && $response['success'] == true && $response['response_code'] == 'validated') {
            $data = [
                "reset" => [
                    "type" => "bearer",
                    "reset_token" => passwordReset()->fromUser($user),
                ],
            ];

            logAction($user->email, 'OTP verification successful', 'OTP verification successful', $request->ip());
            return successResponse("Otp verified. Proceed to change your password.", $data);

        } elseif ($response && $response['success'] == false) {
            logAction($user->email, 'OTP verification failed', $response['response_message'], $request->ip());
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, $response['response_message']);
        } else {
            logAction($user->email, 'OTP verification failed', 'Unable to complete your request', $request->ip());
            return errorResponse();
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!Utility::checkPasswordPolicy($user, $request->input('password'))) {
            logAction($request->input('email'), 'Reset Password Failed', 'Change Password Failed - Failed password policy', $request->ip());
            return errorResponse(ResponseStatusCodes::BAD_REQUEST, 'To keep you safe, you are not permitted to use a password you have used in the last ' . config('app.unique_password') . ' Months');
        }

        $user->passwords()->create([
            'password' => Hash::make($request->input('password')),
        ]);

        $user->password = Hash::make($request->input('password'));
        $user->save();

        logAction($request->input('email'), 'Reset Password successful', 'Reset Password successful', $request->ip());
        return successResponse("Your password has been reset successfully.");
    }
}
