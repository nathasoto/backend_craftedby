<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;//class in Laravel is used to validate incoming request data

class AuthController extends Controller
{

    public function login(Request $request)
    {
        // Validate incoming data directly using validate()
        $request->validate([
            'email' => ['required', 'email'], // Validate 'email' as required and must be a valid email format
            'password' => ['required'], // Validate 'password' as required
        ]);

        // Attempt to authenticate the user with the validated credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            // If authentication is successful, retrieve the authenticated user
            $user = Auth::user();
            // Create an authentication token for the authenticated user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Return the authentication token and token type as a JSON response
            return response()->json([
                'message' => 'Successfully login',
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // If authentication fails, return an error response
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'The provided credentials are incorrect.',
        ], 401); // HTTP status code 401 Unauthorized
    }

    public function register(Request $request): JsonResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string|in:artisan,authClient',
        ]);

        // Assign the role based on user selection
        $role = $request->input('role', );

        // Check if $role is empty or not in the allowed list, assign authClient if empty
        if (empty($role) || !in_array($role, ['artisan', 'authClient'])) {
            $role = 'authClient';
        }

        // Create a new user with the validated data
        $user = User::create([
            'name' => $validatedData['name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Hash the password before storing it
        ]);

        // Assign the role to the user
        $user->assignRole($role);

        // Create an authentication token for the newly created user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Get the user's roles
        $roles = $user->getRoleNames(); // Returns a collection

        // Return the authentication token, token type, and user information as a JSON response
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $roles->isEmpty() ? 'authClient' : $roles->first(), // Default to authenticated_client if no roles assigned
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'id' => $user->id,
            ],

        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        // Revoke the current user's token
        $request->user()->currentAccessToken()->delete();

        // Return a JSON response indicating successful logout
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    public function getRole(Request $request)
    {
        $user = Auth::user(); // Obtener el usuario autenticado actualmente

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Obtener roles del usuario utilizando Spatie
        $roles = $user->getRoleNames();

        // Devolver los roles del usuario como un array
        return response()->json(['roles' => $roles]);
    }


}
