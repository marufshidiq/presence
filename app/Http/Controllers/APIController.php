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

    public function rfid(Request $request)
    {
        $room = \App\Room::where('key', $request->room)->first();
        $card = \App\Card::where('key', $request->card)->first();
        $week = date("W");
        $day = date("w");
        $now = \Carbon\Carbon::now();
        $log = new \App\Log;        

        if($room == null){
            $log->status = json_encode(['message' => 'Room '.$request->room.' not found']);
            $log->save();
            return response()->json(['message' => 'Room not found']);
        }

        if($card == null){
            $log->status = json_encode(['message' => 'Card '.$request->card.' not found']);
            $log->save();
            return response()->json(['message' => 'Card not found']);
        }

        $log->card = $card['id'];
        $log->room = $room['id'];

        $schedule = \App\ClassSchedule::where('room_id', $room['id'])
                                    ->where('week', $week)
                                    ->where('day', $day);

        if($schedule->count() == 0){
            $log->status = json_encode(['message' => 'Schedule not found']);
            $log->save();
            return response()->json(['message' => 'Schedule not found']);
        }
        
        foreach($schedule->get() as $d){ // Get all session in the schedule with room, week and day same as the request
            $start = \Carbon\Carbon::createFromFormat('H:i:s', $d['start']);
            $end = \Carbon\Carbon::createFromFormat('H:i:s', $d['end']);
            if($now->between($start, $end)){ // Check the session
                $class = \App\Classes::find($d['class_id']);
                $class_member = $class->students->pluck('id')->toArray(); // Get the ID of student in class
                
                if(in_array($card->user['id'], $class_member)){ // Check if the User/Student is class member
                    $diff = $now->diffInMinutes($start); // Get the diff between $now and the start session
                    if($diff < 15){ // 15 minutes for limit the check-in
                        if($this->presence($card->user['id'], $d['id'], "1") == 0){
                            $log->status = json_encode(['message' => 'Already check-in']);
                            $log->save();
                            return response()->json(['message' => 'Already check-in']);
                        }
                        $log->status = json_encode(['message' => $now->format("H:i:s").' => In Time']);
                        $log->save();
                        return response()->json(['message' => $now->format("H:i:s").' => In Time']);
                    }
                    else{
                        if($this->presence($card->user['id'], $d['id'], "2") == 0){
                            $log->status = json_encode(['message' => 'Already check-in']);
                            $log->save();
                            return response()->json(['message' => 'Already check-in']);
                        }
                        $log->status = json_encode(['message' => $now->format("H:i:s").' => Late '.$diff.' minutes']);
                        $log->save();
                        return response()->json(['message' => $now->format("H:i:s").' => Late '.$diff.' minutes']);
                    }
                }
                else{
                    $log->status = json_encode(['message' => 'Not Class Member']);
                    $log->save();
                    return response()->json(['message' => 'Not Class Member']);
                }                
            }   
            else { // If $now is not in between this session, then continue to check session
                continue;
            }
        }
        $log->status = json_encode(['message' => 'Not in any session']);
        $log->save();
        return response()->json(['message' => 'Not in any session']);
    }

    public function presence($user_id, $session_id, $status)
    {
        $check = \App\Presence::where('user_id', $user_id)->where('session_id', $session_id)->where('week', date("W"))->count();
        if($check > 0){
            return 0;
        }
        $presence = new \App\Presence;
        $presence->user_id = $user_id;
        $presence->session_id = $session_id;
        $presence->week = date("W");
        $presence->presence = date("Y-m-d H:i:s");
        $presence->status = $status;
        $presence->save();
        return 1;
    }
}
