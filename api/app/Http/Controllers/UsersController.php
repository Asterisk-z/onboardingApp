<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
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
            ]
        ];

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
        return successResponse('Registration Successful', $createUser);
    }
}
