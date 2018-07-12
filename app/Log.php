<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function room()
    {
        return $this->belongsTo('App\Room');
    }

    public function card()
    {
        return $this->belongsTo('App\Card');
    }

}
