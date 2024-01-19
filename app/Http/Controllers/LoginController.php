<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Log user login
            UserActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => 'login',
            ]);

            

            return response()->json(['message' => 'Login successful', 'user' => $user]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        Auth::logout();

        // Log user logout
        UserActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'logout',
        ]);

        return response()->json(['message' => 'Logout successful']);
    }
}
