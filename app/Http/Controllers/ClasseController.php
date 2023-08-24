<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function createClass (Request $request){
        $classe=Classe::create([
            'version'=>$request->version,
            'grade'=>$request->grade,
            'class_name'=>$request->class,
            'invite_code'=>'',
            'Teacher_id' => $request->user()->id,
        ]);

        $classe->invite_code=$classe->generateInviteCode();

        return response()->json([
           'msg' => 'create class success',
           'invite_code' => $classe->invite_code,
        ]);
    }

    public function getAllClasses(Request $request){
        $classes = $request->user()->classes;

         if ($classes->isEmpty()) {
            return response()->json([
                'status' => false,
                'error_msg' => 'no class been create by you',
            ]);
        }

        $formattedClasses = $classes->map(function ($class) {
            return [
                'class_id' => $class->id,
                'grade' => $class->grade,
                'class_name' => $class->class_name,
                'version' => $class->version,
                'invite_code' => $class->invite_code,
                'Teacher_id' => $class->Teacher_id,
            ];
        });

        return response()->json([
            'status' => true,
            'classes' => $formattedClasses,
        ]);
    }

    public function deleteClass(Request $request){
        $class = Classe::where('id',$request->class_id)->first();

        if (!$class) {
            return response()->json([
                'msg' => 'no such class exists',
            ]);
        }

        if($class->Teacher_id == $request->user()->id){
            $class->delete();
            return response()->json([
                'msg' => 'delete class success',
            ]);
        }
        else{
            return response()->json([
                'msg' => 'delete class fail , you are not the owner of this class',
            ]);
        }
    }
}
