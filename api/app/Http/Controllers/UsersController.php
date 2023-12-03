<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\Audit;
use App\Models\User;
use App\Services\AuditLogger;
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
            'password' => 'required|string|min:6',
        ]);

        if (!$user = User::where('email', $request->email)->first()) {
            // log activity
            Audit::create([
                'user' => $request->email,
                'action_performed' => 'Failed Login',
                'action_time' => now(),
                'ip_address' => $request->ip()
            ]);
            // message
            return errorResponse("99", "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($request->password, $user->password)) {
            //
            Audit::create([
                'user' => $request->email,
                'action_performed' => 'Failed Login',
                'action_time' => now(),
                'ip_address' => $request->ip()
            ]);
            return errorResponse("99", "Incorrect login credentials.", [], Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->login($user);
        $data = [
            'authorization' => [
                'type' => 'Bearer',
                'token' =>  $token,
                'expires_in' =>  config('jwt.ttl') * 60
            ]
        ];
        // log activity
        Audit::create([
            'user' => auth()->user()->email,
            'action_performed' => 'Successful Login',
            'action_time' => now(),
            'ip_address' => $request->ip()
        ]);

        return successResponse('Login Successful', $data);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'nationality' => 'required|string',
            'category' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($request->input('password'));
        $createUser = User::create($data);
        // log activity
        Audit::create([
            'user' => $request->email,
            'action_performed' => 'Successful User Registration',
            'action_time' => now(),
            'ip_address' => $request->ip()
        ]);
        return successResponse('Registration Successful', Utility::arrayKeysToCamelCase($createUser->toArray()));
    }
}
