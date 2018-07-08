<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'name', 'sks', 'category', 'group'];

    public function curriculum()
    {
        return $this->belongsTo('App\Curriculum', 'curriculum_id');
    }
}
