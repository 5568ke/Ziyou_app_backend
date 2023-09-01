<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;


class TeacherController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            ],
            'school_id' => 'required|integer|exists:schools,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => False,
                'error_msg' => $validator->errors(),
            ], 422);
        }

        $teacher = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'School_id' => $request->school_id,
        ]);

        return response()->json([
            'status' => True,
            'message' => 'Teacher registered successfully'], 201);
    }

    public function login(Request $request){
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user= Teacher::where('email',$request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => False,
                'error_msg' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $token = $user->createToken('device-name')->plainTextToken;

        return response()->json([
            'status' => True,
            'school_name' => $user->school->name,
            'name' => $user->name,
            'role' => 'teacher',
            'token' => $token,
        ]);
    }

    public function update_login(Request $request){
        $token = $request->user->currentAccessToken();
        $token->forceFill([
            'expires_at' => now()->addMinutes(30),
        ])->save();
        return response()->json([
            'msg'=>'update_success',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Teacher logged out successfully']);
    }

    public function getTeacher(Request $request){
        return $request->user();
    }

}
