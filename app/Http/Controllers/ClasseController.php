<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    //
    public function makeClass (Request $request){
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
}
