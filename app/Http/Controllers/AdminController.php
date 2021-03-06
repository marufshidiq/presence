<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Room;
use App\Course;
use App\Curriculum;
use App\Card;
use App\Period;
use App\Classes;

class AdminController extends Controller
{
    public function listCard()
    {        
        return view('admin.cardlist');
    }

    public function addCard(Request $request)
    {        
        $card = new Card;
        $card->key = $request->key;        
        $card->save();
        return redirect()->back();
    }

    public function deleteCard(Request $request)
    {
        Card::find($request->id)->delete();
        return "success";
    }

    public function setCard(Request $request)
    {
        Card::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        return "success";
    }

    public function assignCard(Request $request)
    {
        Card::where('id', $request->id)->update([
            'user_id' => $request->user
        ]);
        return redirect()->back();
    }

    public function showRoom()
    {        
        return view('admin.roomlist');
    }

    public function addRoom(Request $request)
    {
        $exist = true;
        while($exist){
            $key = rand(100000, 999999);
            if(Room::where('key', $key)->count() == 0){
                $exist = false;
            }
        }

        $room = new Room;
        $room->key = $key;
        $room->name = $request->name;
        $room->save();
        return redirect()->back();
    }

    public function deleteRoom(Request $request)
    {
        Room::find($request->delid)->delete();
        return redirect()->back();
    }
    
    public function listStudent(){
        return view('admin.studentlist');
    }

    public function formAddStudent()
    {
        return view('admin.studentadd');
    }

    public function formEditStudent($id)
    {
        $student = User::find($id);
        $profile = $student->profile;
        return view('admin.studentedit', compact('student', 'profile'));
    }

    public function addStudent(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $profile = $user->profile()->create([
            'born_date' => $request->born,
            'gender' => $request->gender,
            'number_id' => $request->number
        ]);

        return redirect()->route('student.list');
    }

    public function editStudent(Request $request)
    {
        $student = User::find($request->id);
        $student->update([
            'name' =>  $request->name,
            'email' => $request->email
        ]);

        $student->profile()->update([
            'born_date' => $request->born,
            'gender' => $request->gender,
            'number_id' => $request->number
        ]);

        return redirect()->route('student.list');
    }

    public function deleteStudent(Request $request)
    {
        $student = User::find($request->id)->delete();
        return "Success";
    }

    public function listLecture(){
        return view('admin.lecturelist');
    }

    public function formAddLecture()
    {
        return view('admin.lectureadd');
    }

    public function formEditLecture($id)
    {
        $lecture = User::find($id);
        $profile = $lecture->profile;
        return view('admin.lectureedit', compact('lecture', 'profile'));
    }

    public function addLecture(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = "lecturer";
        $user->password = Hash::make($request->password);
        $user->save();

        $profile = $user->profile()->create([
            'born_date' => $request->born,
            'gender' => $request->gender,
            'number_id' => $request->number
        ]);

        return redirect()->route('lecture.list');
    }

    public function editLecture(Request $request)
    {
        $lecture = User::find($request->id);
        $lecture->update([
            'name' =>  $request->name,
            'email' => $request->email
        ]);

        $lecture->profile()->update([
            'born_date' => $request->born,
            'gender' => $request->gender,
            'number_id' => $request->number
        ]);

        return redirect()->route('lecture.list');
    }

    public function deleteLecture(Request $request)
    {
        $lecture = User::find($request->id)->delete();
        return "Success";
    }

    public function listCourse()
    {
        return view('admin.courselist');
    }

    public function formAddCourse()
    {
        return view('admin.courseadd');
    }

    public function formEditCourse($id)
    {
        $course = Course::find($id);

        return view('admin.courseedit', compact('course'));
    }

    public function addCourse(Request $request)
    {
        $course = new Course;
        $course->curriculum_id = $request->curriculum;
        $course->code = $request->code;
        $course->name = $request->name;
        $course->sks = $request->sks;
        $course->category = $request->category;
        $course->group = $request->group;
        $course->save();

        return redirect()->route('course.list');
    }

    public function editCourse(Request $request)
    {
        $course = Course::where('id', $request->id)->update([
            'curriculum_id' => $request->curriculum,
            'code' => $request->code,
            'name' => $request->name,
            'sks' => $request->sks,
            'category' => $request->category,
            'group' => $request->group
        ]);

        return redirect()->route('course.list');
    }

    public function deleteCourse(Request $request)
    {
        Course::find($request->id)->delete();
        return "success";
    }

    public function listCurriculum()
    {
        return view('admin.curriculumlist');
    }

    public function addCurriculum(Request $request)
    {
        $curriculum = new Curriculum;
        $curriculum->name = $request->name;
        $curriculum->save();

        return redirect()->route('curriculum.list');
    }

    public function editCurriculum(Request $request)
    {
        Curriculum::where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('curriculum.list');
    }

    public function deleteCurriculum(Request $request)
    {
        $curriculum = Curriculum::find($request->id);
        if($curriculum['status'] == "1"){            
            return response()->json([
                'error'=>'This is the default Curriculum, you can\'t delete this'
            ], 422);
        }
        $curriculum->delete();
        return redirect()->route('curriculum.list');        
    }

    public function defaultCurriculum(Request $request)
    {
        foreach(Curriculum::all() as $data){
            Curriculum::where('id', $data['id'])->update(['status'=>'0']);
        }
        Curriculum::where('id', $request->id)->update(['status'=>'1']);
        return redirect()->route('curriculum.list');        
    }

    public function showCourseCurriculum(Request $request)
    {
        $curriculum = Curriculum::find($request->id);
        $course = $curriculum->course;
        $f_course = [];

        $x = 1;
        foreach($course as $d){
            $c = [
                'id' => $x++,
                'curriculum' => $d->curriculum['name'],
                'code' => $d['code'],
                'name' => $d['name'],
                'sks' => $d['sks'],
                'category' => $d['category'],
                'group' => $d['group'],
                'action' =>'<button onclick="location.href=\''. route('course.edit.form', ['id'=>$d['id']]) .'\'" class="btn btn-warning waves-effect">Edit</button>
                <button onclick="deleteCourse('.$d['id'].')" class="btn btn-danger waves-effect">Delete</button>'
            ];
            array_push($f_course, $c);
        }

        $ret = [
            'name' => $curriculum['name'],
            'course' => $f_course
        ];

        return response()->json($ret);
    }

    public function listPeriod()
    {
        return view('admin.periodlist');
    }

    public function addPeriod(Request $request)
    {
        $period = new Period;
        $period->name = $request->name;
        $period->save();

        return redirect()->route('period.list');
    }

    public function deletePeriod(Request $request)
    {
        $period = Period::find($request->id);
        if($period['status'] == "1"){            
            return response()->json([
                'error'=>'This is the default Period, you can\'t delete this'
            ], 422);
        }
        $period->delete();
        return redirect()->route('period.list');        
    }

    public function defaultPeriod(Request $request)
    {
        foreach(Period::all() as $data){
            Period::where('id', $data['id'])->update(['status'=>'0']);
        }
        Period::where('id', $request->id)->update(['status'=>'1']);
        return redirect()->route('period.list');        
    }

    public function editPeriod(Request $request)
    {
        Period::where('id', $request->id)->update([
            'name' => $request->name
        ]);

        return redirect()->route('period.list');
    }

    public function listClass()
    {
        return view('admin.classlist');
    }

    public function formAddClass()
    {
        return view('admin.classadd');
    }

    public function addClass(Request $request)
    {
        $class = new Classes;
        $class->name = $request->name;
        $class->periode_id = $request->period;
        $class->course_id = $request->course;
        $class->lecture_id = $request->lecture;
        $class->room_id = $request->room;
        $class->day = $request->day;
        $class->start = $request->start;
        $class->end = $request->end;
        $class->save();        

        return redirect()->route('class.list');
    }

    public function formEditClass($id)
    {
        $class = Classes::find($id);

        return view('admin.classedit', compact('class'));
    }

    public function editClass(Request $request)
    {
        $class = Classes::where('id', $request->id)->update([
            'name' => $request->name,
            'periode_id' => $request->period,
            'course_id' => $request->course,
            'lecture_id' => $request->lecture,
            'room_id' => $request->room,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end
        ]);

        return redirect()->route('class.list');
    }

    public function deleteClass(Request $request)
    {
        Classes::find($request->id)->delete();
        return "success";
    }

    public function checkClass(Request $request)
    {
        $class_list = Classes::where('periode_id', $request->period)
            ->where('room_id', $request->room)
            ->where('day', $request->day)        
            ->get();

        foreach($class_list as $class){
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

    public function showStudent(Request $request)
    {
        $class = Classes::find($request->id);
        $student = $class->students;
        $list_student = [];
        $f_student = [];
        
        foreach($student as $std){
            array_push($list_student, $std['id']);
        }        
        
        foreach(\App\User::where('role', 'student')->get() as $d){
            if(in_array($d['id'], $list_student)){                
                $x = '<input type="checkbox" name="student[]" value="'.$d['id'].'" id="cb-'.$d['id'].'" class="filled-in" checked /><label for="cb-'.$d['id'].'">'.$d['name'].'</label>';
            }
            else {
                $x = '<input type="checkbox" name="student[]" value="'.$d['id'].'" id="cb-'.$d['id'].'" class="filled-in" /><label for="cb-'.$d['id'].'">'.$d['name'].'</label>';
            }
            $c = [
                'id' => $x,                
            ];
            array_push($f_student, $c);
        }

        $ret = [
            'name' => $class['name']." Student List",
            'class' => $f_student
        ];

        return response()->json($ret);        
    }

    public function addClassStudent(Request $request)
    {
        $class = Classes::find($request->id);
        $class->students()->sync($request->student);

        return redirect()->route('class.list');
    }

    public function listPresence()
    {
        return view('admin.presencelist');
    }

    public function listPresenceStudent($id)
    {
        $class = Classes::find($id);
        return view('admin.presencestudentlist', compact('class'));
    }

    public function logPresence(Request $request)
    {
        $class_id = $request->class_id;
        $user_id = $request->user_id;

        $class = \App\Classes::find($class_id);
        $session = $class->schedule;
        $s = 1;
        $ret = [];
        foreach($session as $x){
            $presence = \App\Presence::where('session_id', $x['id'])->where('user_id', $user_id);
            $name = "Session ".$s++;
            $week = $x['week'];
            $hadir = "";
            $ijin = "";
            $alfa = "";
            if($presence->count() >0){
                if($presence->first()['status']=="1"){
                    $hadir = "disabled";
                }
                else if($presence->first()['status']=="2"){
                    $ijin = "disabled";
                }                
            }
            else {
                $alfa = "disabled";
            }

            $status = '<button onclick="setHadir('.$user_id.','.$x['id'].','.$week.')" '.$hadir.' class="btn btn-success waves-effect">HADIR</button>
                       <button onclick="setIjin('.$user_id.','.$x['id'].','.$week.')" '.$ijin.' class="btn btn-warning waves-effect">IJIN</button>
                       <button onclick="setAlfa('.$user_id.','.$x['id'].','.$week.')" '.$alfa.' class="btn btn-danger waves-effect">ALFA</button>';

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

    public function changePresence(Request $request)
    {
        if(($request->action == "1")||($request->action == "2")){
            $presence = \App\Presence::updateOrCreate([
                'user_id' => $request->user_id,
                'session_id' => $request->session_id,
                'week' => $request->week                            
            ],[
                'presence' => date("Y-m-d H:i:s"),
                'status' => $request->action
            ]);
        }
        else {
            $presence = \App\Presence::where('user_id', $request->user_id)
                                    ->where('session_id', $request->session_id)
                                    ->where('week', $request->week)->first();
            $presence->delete();
        }

        return "Success";
    }

    public function listLog()
    {
        return view('admin.loglist');
    }
}
