<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['name', 'course_id', 'lecture_id', 'periode_id', 'room_id', 'day', 'start', 'end'];

    public function students()
    {
        return $this->belongsToMany('App\User', 'class_student', 'class_id', 'student_id');
    }

    public function period()
    {
        return $this->belongsTo('App\Period', 'periode_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }

    public function lecture()
    {
        return $this->belongsTo('App\User', 'lecture_id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room', 'room_id');
    }

    public function the_day()
    {
        $l = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]; // w in PHP Format
        return $l[$this->day];
    }

    public function class_start()
    {        
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->start)->format('H:i');
    }

    public function class_end()
    {        
        return \Carbon\Carbon::createFromFormat('H:i:s', $this->end)->format('H:i');
    }
    
    public function schedule()
    {
        return $this->hasMany('App\ClassSchedule', 'class_id');
    }

    public function weekSchedule()
    {
        foreach($this->schedule as $d){
            if($d['week'] == date("W")){
                return $d;
            }
        }
    }
}
