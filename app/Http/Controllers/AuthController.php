<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);
        return response()->json([
            "success" => true,
            "user" => $user,
            "message" => "$user->name is register successful.",
            "token" => $token->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'email' => ['Your information is incorrect.']
                ]
            ], 401);
        }
        $token = $user->createToken($user->name);

        return response()->json([
            "success" => true,
            "message" => "Login successfully",
            "user" =>  $user,
            "token" => $token->plainTextToken
        ], 200);
    }

    public function profile(Request $request)
    {

        $user = $request->user(); // Get authenticated user

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "Unauthorized",
            ], 401);
        }

        return response()->json([
            "success" => true,
            "message" => "User information retrieved successfully",
            "user" => $user
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            "success" => true,
            'message' => 'You are logged out.'
        ];
    }
}
