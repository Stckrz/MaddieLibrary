<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Log in and create a new API token.
     */
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to retrieve the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is valid
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create a new personal access token
        $token = $user->createToken('api-token')->plainTextToken;

        // Return the token and user details in a JSON response
        return response()->json([
            'message' => 'Login successful.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    /**
     * Register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        //if email already exists, send error
        $userExists = User::where('email', $request->email)->first();

        if ($userExists) {
            return response()->json([
                'error' => 'User already exists',
            ]);
        }

        //create user
        $user = User::create([
            'name' => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        //if creation failed, send error
        if (!$user) {
            return response()->json([
                'error' => 'Registration unsuccessful.',
            ], 500);
        }

        //create token for new user
        $token = $user->createToken('api-token')->plainTextToken;

        //login user and send token. return.
        return response()->json([
            'message' => 'User created successfully.',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    /**
     * Logout (Revoke tokens)
     */
    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }
}
