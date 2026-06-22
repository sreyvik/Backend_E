<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{


    // Register + Auto Login
    public function register(Request $request)
    {


        $request->validate([

            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'

        ]);



        $user = User::create([

            'name'=>$request->name,

            'email'=>$request->email,

            'password'=>Hash::make($request->password)

        ]);



        // Create token after register
        $token = $user->createToken('auth-token')->plainTextToken;



        return response()->json([

            'message'=>'Register success',

            'user'=>$user,

            'token'=>$token

        ],201);


    }




    // Login
    public function login(Request $request)
    {


        $request->validate([

            'email'=>'required|email',

            'password'=>'required'

        ]);



        $user = User::where(

            'email',

            $request->email

        )->first();



        if(!$user || !Hash::check($request->password,$user->password))
        {


            return response()->json([

                'message'=>'Invalid email or password'

            ],401);


        }




        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;



        return response()->json([

            'message'=>'Login success',

            'user'=>$user,

            'token'=>$token

        ]);



    }





    // Logout
    public function logout(Request $request)
    {


        // Delete current token
        $request->user()->currentAccessToken()->delete();



        return response()->json([

            'message'=>'Logout success'

        ]);

    }


}