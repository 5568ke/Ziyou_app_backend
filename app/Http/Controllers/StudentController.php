<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classe;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            ],
            'school_id' => 'required|integer|exists:schools,id', // Assuming you have a 'schools' table with an 'id' column
            'grade' => 'required|integer|between:1,6',
        ]);

        $student  = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'School_id' => $request->school_id,
            'grade' => $request->grade,
            // Add other fields if necessary
        ]);
        return response()->json(['message' => 'Student registered successfully', 'student' => $student], 201);
    }

    public function login(Request $request){
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user= Student::where('email',$request->email)->first();
        if(! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'msg' => ['the provided password are incorrect.'],
            ]);
        }
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['the provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('device-name')->plainTextToken;

        return response()->json([
            'status' => true,
            'school_name' => $user->school->name,
            'name' => $user->name,
            'role' => 'Student',
            'token' => $token,
        ]);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'student logged out successfully']);
    }

    public function enterClass(Request $request)
    {

        $class = Classe::where('invite_code', $request->invite_code)->first();
        if(!$class == null){
            $request->user()->Classe_id = $class->id;
             $request->user()->save();
            return response()->json(['message' => 'student entered class successfully']);
        }
        else{
            return response()->json(['message' => 'student entered class failed']);
        }
    }

    public function getStudent(Request $request)
    {
        return response()->json(['student' => $request->user()]);
    }
}
