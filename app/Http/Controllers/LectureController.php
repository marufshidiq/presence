<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes;

class LectureController extends Controller
{
    public function listClass()
    {
        return view('lecture.classlist');
    }

    public function showStudent(Request $request)
    {
        $class = Classes::find($request->id);
        $student = $class->students;
        $list_student = [];
        
        foreach($student as $s){
            $c = [
                'id' => $s['name']
            ];
            array_push($list_student, $c);
        }

        $ret = [
            'name' => $class['name']." Student List",
            'class' => $list_student
        ];

        return response()->json($ret);        
    }
}
