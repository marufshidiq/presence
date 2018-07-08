<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    protected $table = 'curriculum';

    public function course()
    {
        return $this->hasMany('App\Course');
    }
}
