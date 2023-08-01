<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

    //------------------------------------------------------------------------------------------------
    // REGISTER


    public function register(Request $request)
    {

        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'country' => 'required|string|max:2',
            'currency' => 'required|string|max:3',
            'year_of_birth' => 'required|int',
            'postal_code' => 'required|string|max:15',

        ]);




        // creates the user record in the database 
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // can also use bcrypt - but same underlying code is executed
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'country' => $validatedData['country'],
            'currency' => $validatedData['currency'],
            'year_of_birth' => $validatedData['year_of_birth'],
            'postal_code' => $validatedData['postal_code'],
        ]);


        // generate the access token
        $token = $user->createToken('auth_token')->plainTextToken; // the name 'auth_token' appears to be insignificant 
        //- same behaviour when I called it 'fred'

        // send the access token back in JSON format
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201); // why send back a 201 response
    }




    //------------------------------------------------------------------------------------------------
    // LOGIN



    public function login(Request $request)
    {

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
            'user' => $user,
        ]);
    }

    //------------------------------------------------------------------------------------------------
    // LOGOFF


    public function logoff(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'user logged out'
        ];
    }



    //------------------------------------------------------------------------------------------------
    // ME



    public function me(Request $request)
    {
        return $request->user();
    }


    //------------------------------------------------------------------------------------------------
    // PERDU - APIS



    public function perdulog(Request $request)
    {

        DB::insert('insert into perdulog (type,subtype,details) values (?, ?, ?)', [$request['type'], $request['subtype'], $request['description']]);

        return ['type' => $request['type'], 'subtype' => $request['subtype'], $request['details']];
    }

    public function perdustats(Request $request)
    {

        return ['number' => '17'];
    }}
