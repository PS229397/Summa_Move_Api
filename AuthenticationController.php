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
        Log::info('Register method called', ['request' => $request->all()]);

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

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        Log::info('Register method completed', ['user' => $user]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $tokenResult,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function login(Request $request)
    {
        Log::info('Login method called', ['request' => $request->all()]);

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

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        Log::info('Login method completed', ['user' => $user]);

        return response()->json([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        Log::info('Logout method called', ['request' => $request->all()]);

        $user = $request->user();

        foreach ($user->tokens as $token) {
            $token->delete();
        }

        Log::info('Logout method completed');

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function edit(Request $request)
    {
        Log::info('Edit method called', ['request' => $request->all()]);

        $user = $request->user();

        Log::info('Edit method completed', ['user' => $user]);

        return response()->json([
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

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

        Log::info('Store method completed', ['user' => $user]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        Log::info('Update method called', ['request' => $request->all(), 'user' => $user]);

        $rules = [
            'username' => 'string|max:255',
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:8|confirmed',
        ];

        $request->validate($rules);

        $user->fill($request->all());
        $user->save();

        Log::info('Update method completed', ['user' => $user]);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function delete(Request $request)
    {
        Log::info('Delete method called', ['request' => $request->all()]);

        $user = $request->user();
        $user->delete();

        Log::info('Delete method completed');

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
