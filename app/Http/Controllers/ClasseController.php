<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    //
    public function createClass (Request $request){
        Classe::create([
            'version'=>$request->version,
            'grade'=>$request->grade,
            'class_name'=>$request->class,
            'invite_code'=>$request->invite_code,
            'Teacher_id' => $request->user()->id,
        ]);

        return response()->json([
           'msg' => 'create class success',
        ]);
    }

    public function getAllClasses(Request $request){
        return $request->user()->classes;
    }

    public function deleteClass(Request $request){
        $class = Classe::where('id',$request->class_id)->first();
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
