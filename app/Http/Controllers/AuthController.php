<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Generate a Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return response with token
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
        ], 200);

    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
