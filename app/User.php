<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function classes()
    {
        return $this->belongsToMany('App\Classes', 'class_student', 'student_id', 'class_id');
    }

    public function card()
    {
        return $this->hasOne('App\Card');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
}
