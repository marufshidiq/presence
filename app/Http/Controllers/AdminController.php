<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Room;
use App\Course;
use App\Curriculum;

class AdminController extends Controller
{
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
}
