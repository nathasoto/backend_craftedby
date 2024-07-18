<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    // Function to get all addresses
    public function index()
    {
        $addresses = Address::all(); // Retrieve all addresses from the database

        return response()->json($addresses, 200); // Return the addresses as a JSON response with a 200 status code
    }

    // Function to store a new address
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // user_id is required and must exist in the users table
            'street' => 'required|string|max:255', // street is required, must be a string, and cannot exceed 255 characters
            'city' => 'required|string|max:255', // city is required, must be a string, and cannot exceed 255 characters
            'postal_code' => 'required|string|max:10', // postal_code is required, must be a string, and cannot exceed 10 characters
            'country' => 'required|string|max:255', // country is required, must be a string, and cannot exceed 255 characters
        ]);

        $address = Address::create($validatedData); // Create a new address with the validated data

        // Return a JSON response indicating the address was created successfully, along with the new address and a 201 status code
        return response()->json(['message' => 'Address created successfully', 'address' => $address], 201);
    }

    // Function to delete an address
    public function destroy($id)
    {
        $address = Address::find($id); // Find the address by its ID

        if (!$address) {
            // Return a JSON response indicating the address was not found with a 404 status code
            return response()->json(['message' => 'Address not found'], 404);
        }

        $address->delete(); // Delete the address

        // Return a JSON response indicating the address was deleted successfully with a 200 status code
        return response()->json(['message' => 'Address deleted successfully'], 200);
    }
}
