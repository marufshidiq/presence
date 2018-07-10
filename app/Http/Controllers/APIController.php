<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes;
use App\ClassSchedule;

class APIController extends Controller
{
    public function setWeeklySchedule()
    {
        foreach(Classes::all() as $c){
            $week = date("W");
            $schedule = ClassSchedule::where('class_id', $c['id'])->where('week', $week);
            if($schedule->count() == 0){
                $new = new ClassSchedule;
                $new->class_id = $c['id'];
                $new->week = $week;
                $new->room_id = $c['room_id'];
                $new->day = $c['day'];
                $new->start = $c['start'];
                $new->end = $c['end'];
                $new->save();
            }
        }

        return response()->json(['message'=>'Create Weekly Schedule']);
    }
}
