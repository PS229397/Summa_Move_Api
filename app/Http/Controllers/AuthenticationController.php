<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        Log::info('Register method called', ['request' => $request->all()]); // Log aan het begin

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create a personal access token
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer'
        ], 201);

        Log::info('Register method completed', ['user' => $user]); // Log aan het einde

    }

    public function login(Request $request)
    {
        Log::info('Login method called', ['request' => $request->all()]); // Log aan het begin

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create a personal access token
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ]);

        Log::info('Login method completed', ['user' => $user]); // Log aan het einde

    }

    public function logout(Request $request)
    {
        Log::info('Logout method called', ['request' => $request->all()]); // Log aan het begin

        // Get the user who made the request
        $user = $request->user();

        // Revoke all tokens for the user
        foreach ($user->tokens as $token) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);

        Log::info('Logout method completed'); // Log aan het einde

    }
}
