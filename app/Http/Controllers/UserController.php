<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     title="Craftedby API",
 *     version="1.0",
 *     description="The Craftedby API provides comprehensive endpoints to manage products and users. It supports CRUD operations for products. User management features include user registration, authentication, and profile management. Additionally, the API supports product search and category filtering. Designed for scalability and performance, it ensures robust and secure interactions between clients and the eCommerce backend.",
 *     @OA\Contact(
 *         email="nathalie.soto@le-campus-numerique.fr"
 *     ),
 *     @OA\License(
 *         name="MIT License",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Tag(name="Users", description="Operations about users")
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Use a token to authenticate",
 *     name="Authorization",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=403, description="Unauthorized")
     * )
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return  UserResource::collection(User::all());

    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data",
     *         @OA\JsonContent(
     *             required={"name", "last_name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="role", type="string", enum={"artisan", "authenticated_client"}, example="artisan"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="role", type="string", example="artisan"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="id", type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object"),
     *         ),
     *     ),
     * )
     */
    public function create(Request $request): JsonResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string|in:artisan,authenticated_client',
        ]);

        // Assign the role based on user selection
        $role = $request->input('role', );

        // Check if $role is empty or not in the allowed list, assign authenticated_client if empty
        if (empty($role) || !in_array($role, ['artisan', 'authenticated_client'])) {
            $role = 'authenticated_client';
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
                'role' => $roles->isEmpty() ? 'authenticated_client' : $roles->first(), // Default to authenticated_client if no roles assigned
                'updated_at' => $user->updated_at,
                'created_at' => $user->created_at,
                'id' => $user->id,
            ],

        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Get a specific user by ID",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="User found"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function show(string $id)
    {
//        $user = User::find($id);
//        if (!$user) {
//            return response()->json(['message' => 'User not found'], 404);
//        }
//        return $user;

        if(User::find($id)) {
            return new UserResource(User::findOrFail($id));
        }
        return response()->json(['message' => 'User not found'], 404);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Update a user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *               required={"name", "last_name", "password", "role"},
     *               @OA\Property(property="name", type="string", example="user name"),
     *               @OA\Property(property="last_name", type="string", example="last name"),
     *               @OA\Property(property="password", type="string", example="password12345"),
     *               @OA\Property(property="role", type="string", example="artisan"),
     *
     *        )
     *     ),
     *     @OA\Response(response=200, description="User updated successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response('User not found',404);
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string|in:artisan,authenticated_client',
        ]);

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'User and related orders and addresses deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user', 'error' => $e->getMessage()], 500);
        }

    }
    /**
     * Get the addresses of a specific user.
     *
     * @OA\Get(
     *     path="/api/users/{userId}/addresses",
     *     summary="Get addresses of a user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Addresses found"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function getUserAddresses($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $addresses = $user->addresses; // Obtener las direcciones asociadas al usuario

        return response()->json($addresses, 200);
    }
}
