<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserActivityLog;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function register(Request $request)
    {
        // Validate user registration data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = User::create($validatedData);

        UserActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'registration',
        ]);

        return response()->json($user, 201);
    }
}
