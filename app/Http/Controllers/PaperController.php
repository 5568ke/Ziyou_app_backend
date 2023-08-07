<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paper;

class PaperController extends Controller
{
    public function createPaper(Request $request){
        Paper::create([
            'name' => $request->title,
            'Class_id' => $request->Class_id,
        ]);
        return response()->json([
            'message' => 'Paper created successfully'
        ],201);
    }

    public function getAllPaper_teacher(Request $request){
        $papers = Paper::where('Class_id',$request->Class_id)->get();
        return response()->json([
            'papers' => $papers
        ],201);
    }

    public function updatePaper(Request $request){
        $paper = Paper::find($request->id);
        $paper->status = $request->publish;
        $paper->deadline = $request->deadline;
        $paper->save();
        return response()->json([
            'message' => 'Paper updated successfully'
        ],201);
    }

    public function deletePaper(Request $request){
        $paper = Paper::find($request->id);
        $paper->delete();
        return response()->json([
            'message' => 'Paper deleted successfully'
        ],201);
    }

    // 未完成 需要加上作答紀錄
    public function getAllPaper_student(Request $request){
        $papers = Paper::where('Class_id',$request->user()->Classe()->get()->first()->id)->get();
        return response()->json([
            'papers' => $papers
        ],201);
    }
}
