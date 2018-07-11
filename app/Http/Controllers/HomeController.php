<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role == "admin"){
            return view('admin.home');
        }
        if(\Auth::user()->role == "lecturer"){
            return view('lecture.home');
        }
        if(\Auth::user()->role == "student"){
            return view('student.home');
        }
        return view('home');
    }
}
