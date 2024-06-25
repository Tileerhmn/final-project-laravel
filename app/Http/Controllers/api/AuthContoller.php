<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthContoller extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function login(Request $request)
    {
        $cred = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($cred)) {
            if (auth()->user()->role != 'user') {
                $token = Auth::user()->createToken('token', ['admin'])->plainTextToken;
            } else {
                $token = Auth::user()->createToken('token', ['user'])->plainTextToken;
            }
            return response()->json([
                'status' => 'success',
                'token' => $token
            ], 200);
        } else {

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Token Revoked'
        ]);
    }
}
