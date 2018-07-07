<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Room;
use App\Course;

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
}