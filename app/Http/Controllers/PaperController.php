<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paper;
use App\Models\Problem;
use App\Models\ProblemRecord;
use App\Models\PaperRecord;
use App\Models\Classe;
use App\Models\Student;

class PaperController extends Controller
{
    public function createPaper(Request $request){
        $paper = Paper::create([
            'name' => $request->title,
            'Class_id' => $request->class_id,
        ]);
        $problemsData = $request->problem;
        foreach ($problemsData as $problemData) {
            $problem = Problem::create([
                'problemNum' => $problemData['problemNum'],
                'problemLink' => $problemData['problemLink'],
                'ansLink' => $problemData['ansLink'],
                'answer' => $problemData['answer'],
                'choices' => $problemData['choices'],
            ]);
            $paper->problems()->attach($problem->id);
        }

        return response()->json([
            'message' => 'Paper created successfully'
        ],201);
    }

    public function getPaper(Request $request){
        return Paper::find($request->paper_id)->problems()->get();
    }


    public function updatePaper(Request $request){
        $paper = Paper::find($request->paper_id);
        $paper->name=$request->title;
        $paper->status = $request->status;
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

    public function getAllPaper_teacher(Request $request){
        $papers = Paper::where('Class_id',$request->class_id)->get();
        return response()->json([
            'papers' => $papers
        ],201);
    }

    public function markAllPapers(Request $request){
        $paper_id = $request->paper_id;
        $score = $request->score;

        $paperRecords = PaperRecord::where('paper_id', $paper_id)->get();

        foreach ($paperRecords as $paperRecord) {
            $student_id=$paperRecord->student_id;
            $score=0;
            $position=0;
            $problemRecords=ProblemRecord::where('paper_id',$paper_id)->where('student_id',$student_id)->get();
            foreach($problemRecords as $problemRecord){
                $problem=Paper::find($paper_id)->problems()->where('position',$position)->first();
                if($problemRecord->answer === $problem->answer){
                    $score += 100/count($paperRecords);
                }
                $position++;
            }
            $paperRecord->score=$score;
            $paperRecord->markTime = now();
            $paperRecord->save();
        }

        return response()->json([
            'message' => 'Papers marked successfully'
        ], 201);
    }



    public function getAllPaperRecord(Request $request){
        $paper_id=$request->paper_id;
        $student_id=$request->user()->id;
        $paperRecords=PaperRecord::where('paper_id',$paper_id)->get();
        $records = [];

        foreach ($paperRecords as $paperRecord) {
            $student_id = $paperRecord->student_id;
            $student_name = $paperRecord->student()->name;
            $problemRecords = ProblemRecord::where('paper_id', $paper_id)->where('student_id',$student_id)->get();
            $answers = [];

            foreach ($problemRecords as $problemRecord) {
                $answers[] = $problemRecord->answer;
            }

            $record = [
                'student_name' => $student_name,
                'answer' => $answers,
                'timestamps' => $paperRecord->markTime,
                'score' => $paperRecord->score,
            ];

            $records[] = $record;
        }

        $response = [
            'records' => $records
        ];

        return response()->json($response);

    }

    public function getAllPaper_student(Request $request){
        $class_id=$request->user()->Classe()->get()->first()->id;
        $student_id=$request->user()->id;
        $papers=Classe::find($class_id)->Papers()->get();
        $paperData = [];
        foreach($papers as $paper){
            $problemRecords = ProblemRecord::where('student_id', $student_id)
            ->where('paper_id', $paper->id)
            ->get();
            $answers = [];
            foreach($problemRecords as $problemRecord){
                $answers[]= $problemRecord->answer;
            }
            $paperData[] = [
                'paper_id' => $paper->id,
                'title' => $paper->name,
                'answer'=> $answers,
            ];
        }
        return $paperData;
    }

    public function getPaperRecord_student(Request $request){

        $paper_id=$request->paper_id;
        $student_id=$request->user()->id;

        $paperRecord=PaperRecord::where('student_id', $student_id)
        ->where('paper_id', $paper_id)->first();
        $problemRecords = ProblemRecord::where('student_id', $student_id)
        ->where('paper_id', $paper_id)->get();

        $answer = [];
        foreach($problemRecords as $problemRecord){
            $answers[]= $problemRecord->answer;
        }

        $hasRecord=True;
        if($paperRecord===null){
            $hasRecord=False;
        }

        return response()->json([
            'has_record'=> $hasRecord,
            'answer'=>$answer,
            'timestamps'=>$paperRecord->markTime,
            'score'=>$paperRecord->score,
        ]);
    }

    public function updatePaperRecord(Request $request){
        $paper_id = $request->paper_id;
        $student_id=$request->user()->id;
        $answers = $request->answer;
        $position =0;
        foreach($answers as $answer){
            $problemRecord=ProblemRecord::where('student_id',$student_id)
            ->where('paper_id',$paper_id)->where('position',$position)->first();
            $problemRecord->answer=$answer;
            $problemRecord->save();
            $position++;
        }
    }

    public function CreateProblemRecord(Request $request){
        PaperRecord::create([
            'student_id'=>$request->user()->id,
            'paper_id'=>$request->paper_id,
            'status'=>2,
        ]);
        $answersData = $request->answer;
        $position = 0;
        foreach ($answersData as $answerData) {
            ProblemRecord::create([
                'student_id'=>$request->user()->id,
                'paper_id'=>$request->paper_id,
                'answer'=>$answerData,
                'position'=>$position,
            ]);
            $position++;
        }
        return response()->json([
            'msg' => "create paper record successfully",
        ],201);
    }

}
