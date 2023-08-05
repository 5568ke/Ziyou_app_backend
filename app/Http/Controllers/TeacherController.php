<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class TeacherController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            ],
            'School_id' => 'required|integer|exists:schools,id', // Assuming you have a 'schools' table with an 'id' column
            // Add other validation rules for additional fields if necessary
        ]);

    $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'School_id' => $request->School_id,
            // Add other fields if necessary
        ]);
        return response()->json(['message' => 'Teacher registered successfully', 'teacher' => $teacher], 201);
    }

    public function login(Request $request){
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user= Teacher::where('email',$request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('device-name')->plainTextToken;
    }
}
