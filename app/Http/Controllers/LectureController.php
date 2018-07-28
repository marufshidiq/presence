<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes;
use App\ClassSchedule;

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

    public function rescheduleClassForm($id)
    {
        $class = Classes::find($id);
        $schedule = $class->weekSchedule();

        return view('lecture.classreschedule', compact('class', 'schedule'));
    }

    public function checkClass(Request $request)
    {
        $class_list = ClassSchedule::where('room_id', $request->room)
            ->where('day', $request->day)
            ->where('week', date("W"))
            ->get();

        foreach($class_list as $class){
            if($class['id'] == $request->id){
                continue;
            }
            if(!$this->checkSchedule($request->start, $request->end, $class['start'], $class['end'])){
                return $this->classExist($request->period, $request->start, $request->end, $request->day);
            }
        }

        return response()->json(['message'=>'Class Accepted']);
    }

    public function classExist($period, $start, $end, $day)
    {        
        return response()->json(['message'=>'Class Exist'], 422);
    }

    public function checkSchedule($i_start, $i_end, $i_reqstart, $i_reqend)
    {
        $reqstart = \Carbon\Carbon::createFromFormat('H:i:s', $i_reqstart);
        $reqend = \Carbon\Carbon::createFromFormat('H:i:s', $i_reqend);
        
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $i_start);
        $end = \Carbon\Carbon::createFromFormat('H:i:s', $i_end);

        if($reqstart->between($start, $end)){
            return false;
        }
        if($reqend->between($start, $end)){
            return false;
        }

        if($start->between($reqstart, $reqend)){
            return false;
        }
        if($end->between($reqstart, $reqend)){
            return false;
        }
        return true;
    }

    public function rescheduleClass(Request $request)
    {
        $schedule = ClassSchedule::where('id', $request->id)->update([            
            'room_id' => $request->room,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end
        ]);

        return redirect()->route('home');
    }

    public function startClass($id)
    {
        $schedule = ClassSchedule::find($id);
        $schedule->update([
            'state' => "1",
            'start' => date("H:i:s")
        ]);

        return redirect()->back();
    }
}
