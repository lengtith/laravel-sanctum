<?php

namespace App\Http\Controllers\APIs\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "Successfully created",
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (empty($user) || !Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid email or password"
            ], 401);
        }

        $token = $user->createToken("admin-token", ['create', 'update', 'delete'])->plainTextToken;
        return response()->json([
            "status" => true,
            "message" => "Login successful",
            "token" => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "status" => true,
            "message" => "User logged out",
        ]);
    }

    public function profile()
    {
        $data = auth()->user();
        
        return response()->json([
            "status" => true,
            "message" => "Profile data information",
            "data" => $data
        ]);
    }
}
