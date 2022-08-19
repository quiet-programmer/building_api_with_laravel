<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request) {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        if(is_null($request->name)) {
            return response()->json([
                'message' => 'Name cannot be empty',
            ], 400);
        } else if(is_null($request->email)) {
            return response()->json([
                'message' => 'Email cannot be empty',
            ], 400);
        } else if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Email is no valid',
            ], 400);
        } else if(is_null($request->password)) {
            return response()->json([
                'message' => 'Password cannot be empty',
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request) {
        if(is_null($request->email)) {
            return response()->json([
                'message' => 'Email cannot be empty',
            ], 400);
        } else if(is_null($request->password)) {
            return response()->json([
                'message' => 'Password cannot be empty',
            ], 400);
        }

        // check if email is in record
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Wrong Credentials',
            ], 404);
        }

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    public function getUser(Request $request) {
        $user = $request->user();
        return response()->json([
            'message' => $user,
        ]);
    }
}
