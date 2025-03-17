<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth()->user();
        return response()->json([
                'status' => 'success',
                'accessToken' => $token,
                'userData' => $user
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        try{
            $token = auth()->login($user);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'accessToken' => $token,
                'userData' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => auth()->user(),
            'authorization' => [
                'token' => auth()->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function auth()
    {
        return response()->json([
            'status' => 'success',
            'userData' => auth()->user()
        ]);
    }
}
