<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;




class AuthController extends Controller
{
    //


    public function register(Request $request)
    {

        // ISSUES WITH THIS SOLUTION - 
        // ** if you attept to register the same email address when it already exits, you don't get an error - 
        // ** instead you get an HTML page back - so that would need to be catered for
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // creates the user record in the database 
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // generate the access token
        $token = $user->createToken('auth_token')->plainTextToken;

        // send the access token back in JSON format
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function login(Request $request)
    {
        // This appears to be validating the existence of the user - presumably behind here there is a read from the database where
        // the password passed in is being hashed or whatever to enable the comparison to take place

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        // As I understand it, this is returning the first user whose email address matches that passed in - so operates on the assumption 
        // that the same email address may not be used for multiple users (obvious - but wanting to make sure)

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}
