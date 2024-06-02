<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => ['error' =>'email', 'message' => 'Такого аккаунт не существует']
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'data' => ['error' =>'password', 'message' => 'Неправильный пароль']
            ]);
        }


        return response()->json(['success' => true, 'data' => ['token' => $user->createToken('Laravel')->plainTextToken]]);
    }
}
