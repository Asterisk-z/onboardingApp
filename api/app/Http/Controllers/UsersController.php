<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $login_attempt = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if ($login_attempt) {

                $token = array(
                    "sub" => auth()->user(),
                    "role" => null,
                    "permissions" => null,
                    "exp" => time() + 86400,
                );

                $refreshToken = array(
                    "sub" => auth()->user(),
                    "email" => auth()->user()->email,
                    "role" => null,
                    "category" => auth()->user()->category,

                );
                // return response()->json([config('jwt.secret')], 200);

                $refreshJwt = JWT::encode($refreshToken, config('jwt.secret'), 'HS256');
                $jwt = JWT::encode($token, config('jwt.secret'), 'HS256');

                User::where('id', auth()->user()->id)->update([
                    'refreshToken' => $refreshJwt,
                ]);

                $user = auth()->user();

                $user['role'] = null;
                $user['token'] = $jwt;

                return response()->json($user, 200);

            }

            return response()->json(['error' => 'Invalid username or password'], 401);
        } catch (Exception $error) {
            // echo $error->getMessage();

            return response()->json(['error' => 'An error occurred during create user. Please try again later.'], 500);
        }
    }

    public function register(Request $request): JsonResponse
    {
        try {

            $hash = Hash::make($request->input('password'));

            $createUser = User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'nationality' => $request->input('nationality'),
                'category' => $request->input('category'),
                'password' => $hash,
                'email' => $request->input('email'),
            ]);

            $converted = Utility::arrayKeysToCamelCase($createUser->toArray());
            return response()->json($converted, 201);
        } catch (Exception $error) {
            // echo $error->getMessage();
            return response()->json(['error' => 'An error occurred during register user. Please try again later.'], 500);
        }
    }
}
