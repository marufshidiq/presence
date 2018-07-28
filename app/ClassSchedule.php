<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    protected $fillable = ['class_id', 'week', 'room_id', 'day', 'start', 'end', 'state'];

    public function the_day()
    {
        $l = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]; // w in PHP Format
        return $l[$this->day];
    }

    public function actstate()
    {
        $now = \Carbon\Carbon::now();
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $this->start);
        $end = \Carbon\Carbon::createFromFormat('H:i:s', $this->end);
        if(($now->between($start, $end))&&(date('w')==$this->day)){
            if($this->state == 0){                
                return 1;
            }
            else {
                return 2;
            }
        }
        return 0;
    }
}
