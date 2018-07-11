<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function listPresence()
    {
        return view('student.presencelist');
    }

    public function logPresence(Request $request)
    {
        $class_id = $request->class_id;
        $user_id = $request->user_id;

        $class = \App\Classes::find($class_id);
        $session = $class->schedule()->pluck('id');
        $s = 1;
        $ret = [];
        foreach($session as $x){
            $presence = \App\Presence::where('session_id', $x)->where('user_id', $user_id);
            $name = "Session ".$s++;
            if($presence->count() >0){
                if($presence->first()['status']=="1"){
                    $status = '<span class="label label-success">Hadir</span>';
                }
                else if($presence->first()['status']=="2"){
                    $status = '<span class="label label-warning">Sakit</span>';
                }
            }
            else {
                $status = '<span class="label label-danger">Alfa</span>';
            }

            $c = [
                'name' => $name,
                'status' => $status
            ];

            array_push($ret, $c);
        }

        $resp = [
            'name' => $class['name']." Log",
            'log' => $ret
        ];

        return response()->json($resp);
    }
}
