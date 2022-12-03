<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'required' => ":attribute to'ldirish shart",
            'email' => ":attribute email ko'rinishida bo'lishi kerak",
        ]);

        if ($errors->fails())
            return response()->json([
                'success' => false,
                'errors' => $errors->errors()
            ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => 'false',
                'message' => 'Email or Password error'
            ]);
        }

        return response()->json([
            'success' => true,
            'token' => $user->createToken($request->email)->plainTextToken
        ]);
    }
}
